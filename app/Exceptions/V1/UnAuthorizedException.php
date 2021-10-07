<?php

namespace App\Exceptions\V1;

use App\Exceptions\BaseException;

class UnauthorizedException extends BaseException
{
    public static function unauthorized(): self
    {
        return new self("User does not have valid access token!", '403');
    }

    public static function invalidCredentials(): self
    {
        return new self("Invalid Email or Password", '401');
    }

    public static function unverifiedAccount(): self
    {
        return new self("Please contact support to activate your account.", '401');
    }
}
