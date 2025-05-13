<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Services\ApiResponse;

class ListController extends BaseController
{
    public function showAll()
    {
        return ApiResponse::send(null, 501);
    }

    public function create()
    {
        return ApiResponse::send(null, 501);
    }

    public function show($id)
    {
        return ApiResponse::send(null, 501);
    }

    public function update($id)
    {
        return ApiResponse::send(null, 501);
    }

    public function delete($id)
    {
        return ApiResponse::send(null, 501);
    }
}
