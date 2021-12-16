<?php

use App\Core\Application;
use App\Core\Database\Connection;

Application::bind('config', require 'Config/app.php');
//var_dump(Application::$registry);exit();
try {
    Application::bind('database', Connection::make(
        Application::get('config')['database']['mysql']
    ));
} catch (Exception $e) {
    die($e->getMessage());
}

