<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;

/* Businesses */
use App\Http\Businesses\V1\MemberBusiness;

/* Request Validations */
use App\Http\Requests\V1\MemberRequest;

/* Resource */
use App\Http\Resources\V1\MemberResponse;

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
        $this->module = 'members';
        $ULP = '|' . $this->module . '_all|access_all'; //UPPER LEVEL PERMISSIONS
        $this->middleware('permission:' . $this->module . '_create' . $ULP, ['only' => ['create']]);
    }



    /**
    * Create Member
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
    * @responseFile 200 responses/V1/Member/CreateResponse.json
    * @responseFile 422 responses/ValidationResponse.json
    */
    public function create(MemberRequest $request)
    {
        DB::beginTransaction();
        $member = MemberBusiness::store($request);
        DB::commit();
        return new MemberResponse($member);
    }
}
