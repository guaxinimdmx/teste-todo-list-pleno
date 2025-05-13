<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Services\ApiResponse;
use App\Services\JwtService;

class AuthController extends BaseController
{
    public function login()
    {

        $email = $this->request->getPost('email');

        if (!$email)
            return ApiResponse::send(null, 400,  'Informe seu email');

        $password = $this->request->getPost('password');

        if (!$password)
            return ApiResponse::send(null, 400,  'Informe sua senha');

        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();

        if (!$user || !password_verify($password, $user['password_hash']))
            return ApiResponse::send(null, 401,  'Dados incorretos');

        $jwt = new JwtService();
        $token = $jwt->generateToken($user['id']);

        return ApiResponse::send(['token' => $token], 200,  'Login realizado com sucesso');
    }

    public function me()
    {
        $userId = $this->request->user_id;

        $userModel = new UserModel();
        $user = $userModel->find($userId);

        if (!$user)
            return ApiResponse::send(null, 404,  'Usuário não encontrado');

        unset($user['password_hash']);

        return ApiResponse::send($user, 200,  'Usuário autenticado');
    }
}
