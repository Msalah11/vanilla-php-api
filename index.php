<?php

use App\Core\Route;

require 'vendor/autoload.php';
require 'core/bootstrap.php';


$requestURI = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$requestMethod = $_SERVER['REQUEST_METHOD'];
try {
    Route::load('Routes/web.php')
        ->call($requestURI, $requestMethod);
} catch (Exception $e) {
    die($e->getMessage());
}