<?php

namespace App\Controllers;

use App\Models\User;
use App\Requests\LoginRequest;
use App\Requests\RegisterRequest;
use App\Resources\UserResource;
use App\Traits\JWT;
use App\Traits\HttpResponse;

class UserController extends BaseController
{
    use JWT, HttpResponse;

    private User $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function login()
    {
        $this->validateLogin();
        $request = (new LoginRequest())->getBody();

        $user = $this->user->find(['email' => $request['email']]);

        if(!$user) {
            return $this->sendError('User does not exist with this email address');
        }

        if (!password_verify($request['password'], $user->password)) {
            return $this->sendError('Password is incorrect');
        }

        $this->sendSuccess([
            'token' => $this->generateToken($user->name),
            'user' => (new UserResource())->resource($user)
        ]);
    }

    public function register()
    {
        $this->validateRegister();
        $request = (new RegisterRequest())->modifiedData();
        $user = $this->user->find(['email' => $request['email']]);

        if(!empty($user)) {
            return $this->sendError('This Email is already exits');
        }

        $insertedUser = $this->user->create($request);

        $this->sendSuccess([
            'token' => $this->generateToken($insertedUser->name),
            'user' => (new UserResource())->resource($insertedUser)
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

    private function validateRegister()
    {
        $validation = (new RegisterRequest())->validation();

        if(!empty($validation)) {
            $this->sendValidationError($validation);
            die();
        }
    }

    private function generateToken($name): string
    {
        return $this->generateJwt(['username'=> $name, 'exp'=>(time() + (24*60*60))]);
    }

}