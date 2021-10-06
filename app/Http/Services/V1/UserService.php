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

    public static function get(Request $request, array $with = [], array $roles)
    {
        $users = User::query()->with($with)->roles($roles);

        if ($request->has("users")) {
            $ids = \getIds($request->users);
            $users->orWhereIn('id', $ids);
        }


        if ($request->has('full_name')) {
            $fullName = User::clean($request->full_name);

            if (is_array($fullName)) {
                $users->whereRaw("CONCAT(TRIM(LOWER(first_name)) , ' ' ,TRIM(LOWER(last_name))) in ('" . join("', '", $fullName) . "')");
            } else {
                $users->whereRaw("CONCAT(LOWER(first_name) , ' ' ,LOWER(last_name)) = ? ", $fullName);
            }
        }


        if ($request->has('first_name')) {
            $fname = User::clean($request->first_name);


            if (is_array($fname)) {
                $users->whereRaw("TRIM(LOWER(first_name)) in  ('" . join("', '", $fname) . "')");
            } else {
                $users->whereRaw('TRIM(LOWER(first_name)) = ?', $fname);
            }
        }

        if ($request->has('last_name')) {
            $lname = User::clean($request->last_name);

            if (is_array($lname)) {
                $users->whereRaw("TRIM(LOWER(last_name)) in  ('" . join("', '", $lname) . "')");
            } else {
                $users->whereRaw('TRIM(LOWER(last_name)) = ?', $lname);
            }
        }

        if ($request->has('email')) {
            $email = User::clean($request->email);

            if (is_array($email)) {
                $users->whereRaw("TRIM(LOWER(username)) in  ('" . join("', '", $email) . "')");
            } else {
                $users->whereRaw('TRIM(LOWER(username)) = ?', $email);
            }
        }


        if ($request->has('status')) {
            $ids = \getIds($request->status);
            $users->wherein('status', $ids);
        }

        if ($request->has('from_register_date')) {
            $from = TimeStampHelper::formateDate($request->from_register_date);
            $users->whereDate('created_at', '>=', $from);
        }

        if ($request->has('to_register_date')) {
            $to = TimeStampHelper::formateDate($request->to_register_date);
            $users->whereDate('created_at', '<=', $to);
        }

        return  ($request->filled('pagination') && $request->get('pagination') == false)
                    ? $users->get()
                    : $users->paginate(\pageLimit($request));
    }
}
