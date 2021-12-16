<?php

$router = new \App\Core\Route();

$router->get('', ['HomeController', 'index']);
$router->get('about-us', ['HomeController', 'about']);
