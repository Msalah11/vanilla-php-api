<?php

namespace App\Controllers;

use App\Core\Database\Migration;
use App\Middlewares\AuthMiddleware;

class HomeController extends BaseController
{
    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware());
    }

    public function index()
    {
        echo "Welcome";
    }

    public function install()
    {
        return (new Migration())->doMigrations();
    }
}