<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Services\ApiResponse;

class Api extends BaseController
{
    public function status()
    {
        return ApiResponse::send(null, 200);
    }

    public function fallback()
    {
        return ApiResponse::send(null, 404, 'Route not found');
    }
}
