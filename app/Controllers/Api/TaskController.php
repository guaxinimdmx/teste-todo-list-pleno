<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Services\ApiResponse;

class TaskController  extends BaseController
{
    public function create($listId)
    {
        return ApiResponse::send(null, 501);
    }

    public function update($taskId)
    {
        return ApiResponse::send(null, 501);
    }

    public function delete($taskId)
    {
        return ApiResponse::send(null, 501);
    }
}
