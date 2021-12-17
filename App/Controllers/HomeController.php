<?php

namespace App\Controllers;

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

        if(!empty($this->validateLogin())) {
            echo json_encode(
                $this->validateLogin()
            );
        }

    }


    private function validateLogin(): array
    {
        return (new LoginRequest())->validation();
    }
}