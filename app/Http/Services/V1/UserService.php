<?php

namespace App\Http\Services\V1;

/* Exceptions */
use App\Exceptions\V1\ModelException;
use App\Exceptions\V1\UserException;
use App\Exceptions\V1\FailureException;

/* Models */
use App\Http\Models\User;

/** Helpers */
use App\Helpers\TimeStampHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

    public static function validateToken($token)
    {
        if ($token->expires_at < TimeStampHelper::now()) {
            throw UserException::sessionExpired();
        }

        $days = TimeStampHelper::countDaysBetween($token->expires_at, TimeStampHelper::now(false));

        if ($days > 1) {
            return ;
        }

        $token->expires_at =  TimeStampHelper::getDate(10, $token->expires_at);
        $token->save();
    }

    public static function store(Request $request, $role, $status = null)
    {
        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->phone = $request->phone;
        $user->city = $request->city;
        $user->country = $request->country;
        $user->email = strtolower($request->email);
        $user->password = Hash::make($request->password);
        $user->status = $status ?: User::STATUS['pending'];
        $user->save();

        if (!$user) {
            throw FailureException::serverError();
        }

        self::assignRole($role, $user);

        return $user->fresh();
    }

    /**
    *  This function is used to assign Roles to User
    */
    public static function assignRole($role, $user)
    {
        if (!empty($role)) {
            $user->assignRole($role);
        }
    }
}
