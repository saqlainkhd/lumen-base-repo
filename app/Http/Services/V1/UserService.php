<?php

namespace App\Http\Services\V1;

/* Exceptions */
use App\Exceptions\V1\ModelException;

/* Models */
use App\Http\Models\User;

class UserService
{
    public static function first($with = [], $where = []) : User
    {
        $user = User::with($with)->where($where)->first();

        if (!$user) {
            throw ModelException::dataNotFound();
        }

        return $user;
    }
}
