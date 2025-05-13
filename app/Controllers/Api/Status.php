<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Services\ApiResponse;

class Status extends BaseController
{
    public function index()
    {
        return ApiResponse::send(null, 200);
    }
}
