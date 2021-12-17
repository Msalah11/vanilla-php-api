<?php

use App\Core\Application;
use App\Core\Database\Connection;
use App\Core\Database\QueryBuilder;

Application::bind('config', require 'Config/app.php');
//var_dump(Application::$registry);exit();
try {
    Application::bind('database',
        new QueryBuilder(
            Connection::make(Application::get('config')['database']['mysql'])
        )
    );
} catch (Exception $e) {
    die($e->getMessage());
}

