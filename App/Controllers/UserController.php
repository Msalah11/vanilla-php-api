<?php

namespace App\Controllers;

use App\Models\User;
use App\Requests\LoginRequest;
use App\Requests\RegisterRequest;
use App\Requests\RestPasswordRequest;
use App\Resources\UserResource;
use App\Services\Mail;
use App\Traits\JWT;
use App\Traits\HttpResponse;

class UserController extends BaseController
{
    use JWT, HttpResponse;

    private User $user;
    private RestPasswordRequest $restPasswordRequest;
    private LoginRequest $loginRequest;
    private RegisterRequest $registerRequest;

    public function __construct()
    {
        $this->user = new User();
        $this->loginRequest = new LoginRequest();
        $this->registerRequest = new RegisterRequest();
        $this->restPasswordRequest = new RestPasswordRequest();
    }

    public function login()
    {
        $this->validateRequest('loginRequest');
        $request = $this->loginRequest->getBody();

        $user = $this->user->find(['email' => $request['email']]);

        if(!$user) {
            return $this->sendError('User does not exist with this email address');
        }

        if (!password_verify($request['password'], $user->password)) {
            return $this->sendError('Password is incorrect');
        }

        $token = $this->generateToken($user->name);
        $this->user->update(['id' => $user->id], ['token' => $this->generateToken($user->name)]);

        $this->sendSuccess([
            'user' => (new UserResource())->resource($user),
            'token' => $token
        ]);
    }

    public function register()
    {
        $this->validateRequest('registerRequest');
        $request = $this->registerRequest->modifiedData();
        $user = $this->user->find(['email' => $request['email']]);

        if(!empty($user)) {
            return $this->sendError('This Email is already exits');
        }

        $request['token'] = $this->generateToken( $request['name'] );

        $insertedUser = $this->user->create($request);

        $this->sendSuccess([
            'token' => $request['token'],
            'user' => (new UserResource())->resource($insertedUser)
        ]);
    }

    public function resetPassword()
    {
        $this->validateRequest('restPasswordRequest');
        $request = $this->restPasswordRequest->getBody();
        $user = $this->user->find(['email' => $request['email']]);

        if(empty($user)) {
            return $this->sendError('This Email is not exits');
        }

        $password = rand(2345321232, 9876876778);
        $updateUserPassword = $this->user->update(['id' => $user->id], ['password' => password_hash($password, PASSWORD_DEFAULT)]);

        if(!$updateUserPassword) {
            return $this->sendError('There is an error happend. Please Try again later');
        }

        (new Mail())->send($user->email, $password);

        $this->sendSuccess([], 'The new Password has been sent to your email address');
    }

    private function validateRequest($request)
    {
        $validation = $this->{$request}->validation();

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