<?php



$router = new \App\Core\Route();

$router->get('', ['HomeController', 'index']);
$router->get('install', ['HomeController', 'install']);

// Auth Endpoints
$router->post('api/login', ['UserController', 'login']);
$router->post('api/register', ['UserController', 'register']);
$router->post('api/password-reset', ['UserController', 'resetPassword']);

// Lists Endpoints
$router->post('api/lists', ['ListController', 'create']);
$router->put('api/lists', ['ListController', 'update']);
$router->delete('api/lists', ['ListController', 'delete']);
$router->post('api/lists/items', ['ListController', 'addItem']);
