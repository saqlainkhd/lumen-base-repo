<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;

/* Businesses */
use App\Http\Businesses\V1\AuthenticationBusiness;

/* Request Validations */
use App\Http\Requests\V1\LoginRequest;

/* Resource */
use App\Http\Resources\V1\AuthenticationResponse;

/**
 * @group Authentication
 */
class AuthController extends Controller
{

    /**
     * Login
     * This function is useful for userlogin, to return access token for users.
     *
     * @header Client-ID
     * @header Client-Secret
     * @bodyParam email email required Example: demo@domain.com
     * @bodyParam password string required Example: 123456
     *
     *
     * @responseFile 200 responses/V1/Auth/LoginResponse.json
     * @responseFile 422 responses/ValidationResponse.json
     */
    public function login(LoginRequest $request)
    {
        $user = AuthenticationBusiness::login($request);
        return new AuthenticationResponse($user);
    }
}
