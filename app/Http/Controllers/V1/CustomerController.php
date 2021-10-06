<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;

/* Businesses */
use App\Http\Businesses\V1\CustomerBusiness;

/* Request Validations */
use App\Http\Requests\V1\CustomerRequest;
use App\Http\Requests\V1\CustomerListRequest;
use App\Http\Requests\V1\SmartSearchRequest;

/* Resource */
use App\Http\Resources\V1\CustomerResponse;
use App\Http\Resources\V1\CustomersResponse;
use App\Http\Resources\V1\SmartSearchResponse;
use App\Http\Resources\SuccessResponse;

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
        $this->module = 'customers';
        $ULP = '|' . $this->module . '_all|access_all'; //UPPER LEVEL PERMISSIONS
        $this->middleware('permission:' . $this->module . '_list' . $ULP, ['only' => ['index']]);
        $this->middleware('permission:' . $this->module . '_create' . $ULP, ['only' => ['create']]);
        $this->middleware('permission:' . $this->module . '_detail' . $ULP, ['only' => ['show']]);
        $this->middleware('permission:' . $this->module . '_delete' . $ULP, ['only' => ['destory']]);
        $this->middleware('permission:' . $this->module . '_update' . $ULP, ['only' => ['update']]);
        $this->middleware('permission:' . $this->module . '_search' . $ULP, ['only' => ['search']]);
    }

    /**
    * Get Customers
    *
    * @authenticated
    * @header Authorization Bearer token
    *
    * @urlParam users string 1,2,3,4
    * @urlParam email string ex: abc.com,xyz.co
    * @urlParam phone string ex: 123,123456
    * @urlParam status string ex: pending,active,blocked
    * @urlParam to_date string Example: Y-m-d
    * @urlParam from_date string Example: Y-m-d
    * @urlParam pagination boolean
    *
    * @responseFile 200 responses/V1/Customer/ListResponse.json
    * @responseFile 401 responses/ValidationResponse.json
    *
    */

    public function index(CustomerListRequest $request)
    {
        $customers = CustomerBusiness::get($request);
        return new CustomersResponse($customers);
    }


    /**
    * Create Customer
    *
    * @authenticated
    * @header Authorization Bearer token
    *
    * @bodyParam first_name string required User first name Example: Jon
    * @bodyParam last_name string required User last name Example: Doe
    * @bodyParam email email required User email address Example: customer@domain.com
    * @bodyParam password string required User password Example: abcd1234
    * @bodyParam password_confirmation string required User password Example: abcd1234
    * @bodyParam phone string required User contact number Example: 12
    * @bodyParam city Integer required
    * @bodyParam country string required
    * @bodyParam status string required ex: pending,active
    *
    * @responseFile 200 responses/V1/Customer/CreateResponse.json
    * @responseFile 422 responses/ValidationResponse.json
    */
    public function create(CustomerRequest $request)
    {
        DB::beginTransaction();
        $customer = CustomerBusiness::store($request);
        DB::commit();
        return new CustomerResponse($customer);
    }


    /**
    * Show Customer Detail
    *
    * @authenticated
    * @header Authorization Bearer token
    *
    * @urlParam id integer required
    *
    * @responseFile 200 responses/V1/Customer/CreateResponse.json
    * @responseFile 401 responses/ValidationResponse.json
    *
    */
    public function show(int $id)
    {
        $customer = CustomerBusiness::show($id);
        return new CustomerResponse($customer);
    }

    /**
    * Delete Customer
    *
    * @authenticated
    * @header Authorization Bearer token
    *
    * @urlParam id integer required
    *
    * @responseFile 200 responses/SuccessResponse.json
    * @responseFile 401 responses/ValidationResponse.json
    *
    */
    public function destory(int $id)
    {
        $customer = CustomerBusiness::delete($id);
        return new SuccessResponse([]);
    }

    /**
    * Update Customer
    *
    * @authenticated
    * @header Authorization Bearer token
    *
    * @urlParam id integer required
    * @bodyParam first_name string
    * @bodyParam last_name string
    * @bodyParam email email required
    * @bodyParam phone string required
    * @bodyParam city Integer required
    * @bodyParam country string required
    * @bodyParam status string required ex: pending,active
    *
    * @responseFile 200 responses/V1/Customer/CreateResponse.json
    * @responseFile 422 responses/ValidationResponse.json
    */
    public function update(CustomerRequest $request, int $id)
    {
        DB::beginTransaction();
        $customer = CustomerBusiness::update($request, $id);
        DB::commit();
        return new CustomerResponse($customer);
    }

    /**
    *
    * Smart Search
    *
    * @authenticated
    * @header Authorization Bearer token
    *
    * @urlParam field string required ex: name or email
    * @urlParam value string required ex: Ali or ali@gmail.com
    * @urlParam deleted boolean
    *
    * @responseFile 200 responses/V1/Customer/SmartSearchResponse.json
    * @responseFile 422 responses/ValidationResponse.json
    *
    */
    public static function search(SmartSearchRequest $request)
    {
        $data = CustomerBusiness::search($request);
        return new SmartSearchResponse($data);
    }
}
