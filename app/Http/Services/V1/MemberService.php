<?php

namespace App\Http\Services\V1;

/* Models */
use App\Http\Models\Member;
use App\Http\Models\User;

/* Helpers */
use Illuminate\Http\Request;

/* Exceptions */
use App\Exceptions\V1\FailureException;

class MemberService
{
    public static function store(User $user, $status = null) : Member
    {
        $memeber = new Member();
        $memeber->user_id = $user->id;
        $memeber->status = $status ?: User::STATUS['pending'];
        $memeber->save();

        if (!$memeber) {
            throw FailureException::serverError();
        }

        return $memeber;
    }

    public static function update(Member $member, $status = null) : Member
    {
        $member->status = $status ?: User::STATUS['pending'];
        $member->save();

        if (!$member) {
            throw FailureException::serverError();
        }

        return $member;
    }
}
