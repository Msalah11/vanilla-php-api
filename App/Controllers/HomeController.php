<?php

namespace App\Controllers;

use App\Core\Database\Migration;
use App\Middlewares\AuthMiddleware;
use App\Requests\LoginRequest;
use App\Models\User;

class HomeController extends BaseController
{
    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware());
    }

    public function index()
    {
        $users = (new User())->all();
        var_dump($users);
        exit();
    }

    public function install()
    {
        return (new Migration())->doMigrations();
    }

    private function validateLogin(): array
    {
        return (new LoginRequest())->validation();
    }
}