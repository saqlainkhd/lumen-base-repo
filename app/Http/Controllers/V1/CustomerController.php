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
    public function __construct()
    {
        $this->module = 'invoices';
        $ULP = '|' . $this->module . '_all|access_all'; //UPPER LEVEL PERMISSIONS
        $this->middleware('permission:' . $this->module . '_create' . $ULP, ['only' => ['create']]);
    }

    /**
    * Create Customer
    *
    * @bodyParam first_name string required User first name Example: Jon
    * @bodyParam last_name string required User last name Example: Doe
    * @bodyParam email email required User email address Example: customer@domain.com
    * @bodyParam password string required User password Example: abcd1234
    * @bodyParam password_confirmation string required User password Example: abcd1234
    * @bodyParam phone string optional User contact number module Example: 12
    * @bodyParam city Integer required
    * @bodyParam country string required
    * @bodyParam status string required ex: pending,active
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
