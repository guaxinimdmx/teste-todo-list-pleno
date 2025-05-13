<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Services\ApiResponse;

class Fallback extends BaseController
{
    public function index()
    {
        return ApiResponse::send(null, 404, 'Route not found');
    }
}
