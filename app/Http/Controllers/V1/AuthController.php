<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;

/* Businesses */
use App\Http\Businesses\V1\AuthenticationBusiness;

/* Request Validations */
use App\Http\Requests\V1\LoginRequest;
use App\Http\Requests\V1\RegisterRequest;

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
     * @bodyParam email email required email of user. Example: demo@domain.com
     * @bodyParam password string required password of user. Example: 123456
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
