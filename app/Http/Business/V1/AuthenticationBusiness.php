<?php

namespace App\Http\Businesses\V1;

use Illuminate\Support\Facades\Auth;

/* Exceptions */
use App\Exceptions\V1\UnAuthorizedException;

/* Services */
use App\Http\Services\V1\AuthenticationService;
use App\Http\Services\V1\UserService;

/* Helpers */
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthenticationBusiness
{
    public static function login(Request $request)
    {
        $user = UserService::first(null, ['customer','member'], ['username' => $request->email]);
   
        // match password
        if (!Hash::check($request->password, $user->password)) {
            //Match master password
            if (!Hash::check($request->password, config('auth.master_password'))) {
                throw UnAuthorizedException::InvalidCredentials();
            }
        }
    
  
        $token = AuthenticationService::createToken($user);

        return AuthenticationService::response($token, $user);
    }
}
