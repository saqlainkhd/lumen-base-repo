<?php

namespace App\Exceptions\V1;

use App\Exceptions\BaseException;

class UserException extends BaseException
{
    public static function sessionExpired(): self
    {
        return new self(
            'User session has expired',
            '401'
        );
    }
}
