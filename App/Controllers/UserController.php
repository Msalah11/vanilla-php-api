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


        $token = $this->generateJwt(['username'=> 'salah', 'exp'=>(time() + 60)]);

        $this->sendSuccess([
            'token' => $token
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