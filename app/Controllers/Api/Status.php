<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;

class Status extends BaseController
{
    public function index()
    {
        return $this->response
            ->setStatusCode(200)
            ->setJSON([
                'erro' => false,
                'message' => 'Ok',
                'status' => 200
            ]);
    }
}
