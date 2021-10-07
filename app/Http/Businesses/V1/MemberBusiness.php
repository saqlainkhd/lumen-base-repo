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
    public static function store(Request $request)
    {
        $status = ($request->filled('status')) ? User::STATUS[$request->status] : null;
        $user = UserService::store($request, 'memeber', $status);
        $memeber = MemberService::store($user, $status);
        return $user->load('memeber');
    }
}
