<?php

$router = new \App\Core\Route();

$router->get('', ['HomeController', 'index']);

//var_dump($router->routes);