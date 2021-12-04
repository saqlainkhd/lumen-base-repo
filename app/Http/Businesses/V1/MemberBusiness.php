<?php
namespace App\Http\Businesses\V1;

use Illuminate\Support\Facades\Auth;

/* Exceptions */
use App\Exceptions\V1\UnauthorizedException;
use App\Exceptions\V1\ModelException;
/* Services */
use App\Http\Services\V1\UserService;
use App\Http\Services\V1\MemberService;

/* Models */
use App\Http\Models\User;

/* Helpers */
use Illuminate\Http\Request;

class MemberBusiness
{
    public static function get(Request $request)
    {
        return UserService::get($request, ['member'], ['member']);
    }

    public static function store(Request $request)
    {
        $status = ($request->filled('status')) ? User::STATUS[$request->status] : null;
        $user = UserService::store($request, 'member', $status);
        $memeber = MemberService::store($user, $status);
        return $user->load('member');
    }

    public static function show(int $id)
    {
        return UserService::first(['member'], ['id' => $id]);
    }

    public static function update(Request $request, int $id)
    {
        $user = UserService::first(['member'], ['id' => $id]);

        if ($user->id != \Auth::id() && !\Auth::user()->can('access_all')) {
            throw ModelException::dataNotFound();
        }

        $status = ($request->filled('status')) ? User::STATUS[$request->status] : null;
        $user = UserService::update($user, $request, $status);
        $memeber = MemberService::update($user->member, $status);
        return $user->load('member');
    }

    public static function search(Request $request)
    {
        $request->merge([$request->field => $request->value]);
        $users =  UserService::search($request, ['member']);
        $results = [];
        
        if ($users) {
            foreach ($users as $key => $user) {
                $data = new \stdClass;
                $data->id = $user->id;
                $data->value = $user->first_name . ' '.$user->last_name ;
                $results[] = $data;
            }
        }
        
        return collect($results);
    }

    public static function delete(int $id) : void
    {
        $user = UserService::first(['member'], ['id' => $id]);
        UserService::delete($user);
    }
}
