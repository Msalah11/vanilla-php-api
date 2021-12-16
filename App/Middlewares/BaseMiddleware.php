<?php

namespace App\Middlewares;


abstract class BaseMiddleware
{
    abstract public function handle();
}