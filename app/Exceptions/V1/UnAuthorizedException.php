<?php

namespace App\Exceptions\V1;

use App\Exceptions\BaseException;

class UnAuthorizedException extends BaseException
{
    public static function userUnauthorized(): self
    {
        return new self("User does not have valid access token!", '403');
    }

    public static function invalidCredentials(): self
    {
        return new self("Invalid Email or Password", '401');
    }
}
