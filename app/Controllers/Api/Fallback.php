<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;

class Fallback extends BaseController
{
    public function index()
    {
        return $this->response
            ->setStatusCode(404)
            ->setJSON([
                'erro' => true,
                'message' => 'Route not found',
                'status' => 404
            ]);
    }
}
