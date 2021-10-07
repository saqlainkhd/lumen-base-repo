<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;

/* Businesses */
use App\Http\Businesses\V1\MemberBusiness;

/* Request Validations */
use App\Http\Requests\V1\MemberRequest;
use App\Http\Requests\V1\MemberListRequest;

/* Resource */
use App\Http\Resources\V1\MemberResponse;
use App\Http\Resources\V1\MembersResponse;

/* Helpers */
use Illuminate\Http\Request;
use DB;

/**
 * @group Member
 */
class MemberController extends Controller
{
    public function __construct()
    {
        $this->module = 'members';
        $ULP = '|' . $this->module . '_all|access_all'; //UPPER LEVEL PERMISSIONS
        $this->middleware('permission:' . $this->module . '_list' . $ULP, ['only' => ['index']]);
        $this->middleware('permission:' . $this->module . '_create' . $ULP, ['only' => ['create']]);
        $this->middleware('permission:' . $this->module . '_detail' . $ULP, ['only' => ['show']]);
        $this->middleware('permission:' . $this->module . '_update' . $ULP, ['only' => ['update']]);
    }

    /**
    * Get Members
    *
    * @authenticated
    * @header Authorization Bearer token
    *
    * @urlParam users string 1,2,3,4
    * @urlParam email string ex: abc.com,xyz.co
    * @urlParam phone string ex: 123,123456
    * @urlParam name string
    * @urlParam status string ex: pending,active,blocked
    * @urlParam to_date string Example: Y-m-d
    * @urlParam from_date string Example: Y-m-d
    * @urlParam pagination boolean
    *
    * @responseFile 200 responses/V1/Member/ListResponse.json
    * @responseFile 401 responses/ValidationResponse.json
    *
    */

    public function index(MemberListRequest $request)
    {
        $members = MemberBusiness::get($request);
        return new MembersResponse($members);
    }


    /**
    * Create Member
    *
    * @authenticated
    * @header Authorization Bearer token
    *
    * @bodyParam first_name string required User first name Example: Jon
    * @bodyParam last_name string required User last name Example: Doe
    * @bodyParam email email required User email address Example: member@domain.com
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

    /**
    * Show Member Detail
    *
    * @authenticated
    * @header Authorization Bearer token
    *
    * @urlParam id integer required
    *
    * @responseFile 200 responses/V1/Member/CreateResponse.json
    * @responseFile 401 responses/ValidationResponse.json
    *
    */
    public function show(int $id)
    {
        $member = MemberBusiness::show($id);
        return new MemberResponse($member);
    }

    /**
    * Update Member
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
    * @bodyParam status string required ex: pending or active
    *
    * @responseFile 200 responses/V1/Member/CreateResponse.json
    * @responseFile 422 responses/ValidationResponse.json
    */
    public function update(MemberRequest $request, int $id)
    {
        DB::beginTransaction();
        $member = MemberBusiness::update($request, $id);
        DB::commit();
        return new MemberResponse($member);
    }
}
