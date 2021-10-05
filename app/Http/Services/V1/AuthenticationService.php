<?php

namespace App\Http\Services\V1;

/* Models */
use App\Http\Models\User;

class AuthenticationService
{
    public static function createToken(User $user)
    {
        $tokenResult = $user->createToken('Password Grant Client');
        $token = $tokenResult->token;
        $token->expires_at = (new \DateTime('now'))->modify("+10 day");
        $token->save();

        return $tokenResult;
    }

    public static function response($auth, User $user)
    {
        return (object)[
            'access_token' => $auth->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => ($auth->token->expires_at)->format('Y-m-d H:i:s'),
            'user' => $user,
            'permissions' => $user->getAllPermissions()
        ];
    }
}
