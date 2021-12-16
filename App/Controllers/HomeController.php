<?php

namespace App\Controllers;

use App\Middlewares\AuthMiddleware;

class HomeController extends BaseController
{
    public function __construct()
    {
//        $this->registerMiddleware(new AuthMiddleware());
    }

    public function index()
    {
        echo 'welcome';
    }

    public function about()
    {
        echo 'about us';
    }
}