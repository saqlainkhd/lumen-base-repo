<?php
namespace App\Http\Businesses\V1;

use Illuminate\Support\Facades\Auth;

/* Exceptions */
use App\Exceptions\V1\UnauthorizedException;
use App\Exceptions\V1\ModelException;
/* Services */
use App\Http\Services\V1\UserService;
use App\Http\Services\V1\CustomerService;

/* Models */
use App\Http\Models\User;
use App\Http\Models\Customer;

/* Helpers */
use Illuminate\Http\Request;

class CustomerBusiness
{
    public static function get(Request $request)
    {
        return UserService::get($request, ['customer'], ['customer']);
    }

    public static function store(Request $request)
    {
        $status = ($request->filled('status')) ? User::STATUS[$request->status] : null;
        $user = UserService::store($request, 'customer', $status);
        $customer = CustomerService::store($user, $status);
        return $user->load('customer');
    }

    public static function show(int $id)
    {
        return UserService::first(['customer'], ['id' => $id]);
    }

    public static function delete(int $id) : void
    {
        $user = UserService::first(['customer'], ['id' => $id]);
        UserService::delete($user);
    }

    public static function update(Request $request, int $id)
    {
        $user = UserService::first(['customer'], ['id' => $id]);

        if ($user->id != \Auth::id() && !\Auth::user()->can('access_all')) {
            throw ModelException::dataNotFound();
        }

        $status = ($request->filled('status')) ? User::STATUS[$request->status] : null;
        $user = UserService::update($user, $request, $status);
        $customer = CustomerService::update($user->customer, $status);
        return $user->load('customer');
    }

   
    public static function search(Request $request)
    {
        $request->merge([$request->field => $request->value]);
        $users =  UserService::search($request, ['customer']);
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
}
