<?php

namespace App\Http\Services\V1;

/* Models */
use App\Http\Models\Customer;
use App\Http\Models\User;

/* Helpers */
use Illuminate\Http\Request;

/* Exceptions */
use App\Exceptions\V1\FailureException;

class CustomerService
{
    public static function store(User $user, $status = null)
    {
        $customer = new Customer();
        $customer->user_id = $user->id;
        $customer->status = $status ?: User::STATUS['pending'];
        $customer->save();

        if (!$customer) {
            throw FailureException::serverError();
        }

        return $customer;
    }

    public static function update(Customer $customer, $status = null)
    {
        $customer->status = $status ?: User::STATUS['pending'];
        $customer->save();

        if (!$customer) {
            throw FailureException::serverError();
        }

        return $customer;
    }
}
