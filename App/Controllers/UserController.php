<?php

namespace App\Controllers;

use App\Models\User;
use App\Requests\LoginRequest;
use App\Traits\JWT;
use App\Traits\HttpResponse;

class UserController extends BaseController
{
    use JWT, HttpResponse;

    public function login()
    {
        $this->validateLogin();
        $request = (new LoginRequest())->getBody();

        $user = (new User())->find(['email' => $request['email']]);

        if(!$user) {
            return $this->sendError('User does not exist with this email address');
        }

        if (!password_verify($request['password'], $user->password)) {
            return $this->sendError('Password is incorrect');
        }

        $token = $this->generateJwt(['username'=> $user->name, 'exp'=>(time() + 60)]);

        $this->sendSuccess([
            'token' => $token,
            'user' => $user
        ]);
    }

    private function validateLogin()
    {
        $validation = (new LoginRequest())->validation();

        if(!empty($validation)) {
            $this->sendValidationError($validation);
            die();
        }
    }
}