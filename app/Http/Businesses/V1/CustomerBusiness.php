<?php
namespace App\Http\Businesses\V1;

use Illuminate\Support\Facades\Auth;

/* Exceptions */
use App\Exceptions\V1\UnauthorizedException;

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
        $status = ($request->filled('status')) ? Customer::STATUS[$request->status] : null;
        $user = UserService::store($request, 'customer', $status);
        $customer = CustomerService::store($user, $status);
        return $user->load('customer');
    }
}
