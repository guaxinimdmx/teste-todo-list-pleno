<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Services\ApiResponse;

class AuthController extends BaseController
{
    public function login()
    {
        return ApiResponse::send(null, 501);
    }

    public function logout()
    {
        return ApiResponse::send(null, 501);
    }

    public function me()
    {
        return ApiResponse::send(null, 501);
    }
}
