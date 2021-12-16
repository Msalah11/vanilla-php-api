<?php

namespace App\Controllers;

use App\Middlewares\BaseMiddleware;

class BaseController
{
    protected array $middlewares = [];

    public function registerMiddleware(BaseMiddleware $middleware): BaseMiddleware
    {
        return $this->middlewares[] = $middleware;
    }

    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }
}