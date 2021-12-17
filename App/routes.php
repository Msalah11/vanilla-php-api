<?php

$router = new \App\Core\Route();

$router->get('', ['HomeController', 'index']);
$router->get('install', ['HomeController', 'install']);
