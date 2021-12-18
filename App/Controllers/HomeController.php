<?php

namespace App\Controllers;

use App\Core\Database\Migration;

class HomeController extends BaseController
{

    public function index()
    {
        echo "Welcome";
    }

    public function install()
    {
        return (new Migration())->doMigrations();
    }
}