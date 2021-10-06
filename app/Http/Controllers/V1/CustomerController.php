<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;

/* Businesses */
use App\Http\Businesses\V1\CustomerBusiness;

/* Request Validations */
use App\Http\Requests\V1\CreateCustomerRequest;

/* Resource */
use App\Http\Resources\V1\CustomerResponse;

use DB;

/**
 * @group Customer
 */
class CustomerController extends Controller
{

    /**
     * Create Customer
     *
     *
     * @responseFile 200 responses/V1/Customer/CreateResponse.json
     * @responseFile 422 responses/ValidationResponse.json
     */
    public function create(CreateCustomerRequest $request)
    {
        DB::beginTransaction();
        $customer = CustomerBusiness::store($request);
        DB::commit();
        return new CustomerResponse($customer);
    }
}
