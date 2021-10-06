<?php
namespace App\Http\Businesses\V1;

use Illuminate\Support\Facades\Auth;

/* Exceptions */
use App\Exceptions\V1\UnAuthorizedException;

/* Services */
use App\Http\Services\V1\UserService;
use App\Http\Services\V1\CustomerService;

/* Models */
use App\Http\Models\Customer;

/* Helpers */
use Illuminate\Http\Request;

class CustomerBusiness
{
    public static function store(Request $request)
    {
        $user = UserService::store($request, 'customer');
        // $customer = CustomerService::store($user, Customer::STATUS['pending']);
        return $user->fresh();
    }
}
