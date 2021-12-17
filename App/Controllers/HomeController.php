<?php

namespace App\Controllers;

use App\App\Models\User;
use App\Middlewares\AuthMiddleware;
use App\Requests\LoginRequest;

class HomeController extends BaseController
{
    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware());
    }

    public function index()
    {
        $users = (new User())->all();
        var_dump($users);exit();
    }


    private function validateLogin(): array
    {
        return (new LoginRequest())->validation();
    }
}