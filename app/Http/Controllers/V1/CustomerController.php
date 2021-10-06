<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;

/* Businesses */
use App\Http\Businesses\V1\CustomerBusiness;

/* Request Validations */
use App\Http\Requests\V1\CreateCustomerRequest;

/* Resource */
use App\Http\Resources\V1\CustomerResponse;
use App\Http\Resources\V1\CustomersResponse;

/* Helpers */
use Illuminate\Http\Request;
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
        $this->middleware('permission:' . $this->module . '_list' . $ULP, ['only' => ['index']]);
        $this->middleware('permission:' . $this->module . '_create' . $ULP, ['only' => ['create']]);
    }

    /**
    * Get Customers
    *
    * @authenticated
    *
    * @urlParam users string [1,2,3,4]
    * @urlParam search string ex: name or id
    * @urlParam search_by string ex: name,id
    * @urlParam status string ex: pending,active,blocked
    * @urlParam to_register_date string Example: Y-m-d
    * @urlParam from_register_date string Example: Y-m-d
    *
    * @responseFile 200 responses/V1/Customer/ListResponse.json
    * @responseFile 401 responses/ValidationResponse.json
    *
    */

    public function index(Request $request)
    {
        $customers = CustomerBusiness::get($request);
        return new CustomersResponse($customers);
    }


    /**
    * Create Customer
    *
    * @authenticated
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
