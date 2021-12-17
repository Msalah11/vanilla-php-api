<?php



$router = new \App\Core\Route();

$router->get('', ['HomeController', 'index']);
$router->get('install', ['HomeController', 'install']);

// Auth Endpoints
$router->post('api/login', ['UserController', 'login']);
$router->post('api/register', ['UserController', 'register']);