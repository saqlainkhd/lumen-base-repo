<?php
namespace App\Http\Businesses\V1;

use Illuminate\Support\Facades\Auth;

/* Exceptions */
use App\Exceptions\V1\UnauthorizedException;

/* Services */
use App\Http\Services\V1\AuthenticationService;
use App\Http\Services\V1\UserService;

/* Helpers */
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

/* Models */
use App\Http\Models\User;

class AuthenticationBusiness
{
    public static function login(Request $request)
    {
        $user = UserService::first([], ['email' => $request->email]);
   
        // match password
        if (!Hash::check($request->password, $user->password)) {
            //Match master password
            if (!Hash::check($request->password, config('auth.master_password'))) {
                throw UnauthorizedException::InvalidCredentials();
            }
        }

        if ($user->status == User::STATUS['pending']) {
            throw UnauthorizedException::unverifiedAccount();
        }
    
  
        $token = AuthenticationService::createToken($user);

        return AuthenticationService::response($token, $user);
    }
}
