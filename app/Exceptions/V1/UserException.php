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

    public static function permission(): self
    {
        return new self(
            'Permission denied!',
            '403'
        );
    }
}
