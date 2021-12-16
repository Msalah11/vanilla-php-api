<?php

namespace App\Middlewares;

use App\Exceptions\ForbiddenException;
use Closure;
use Exception;

class AuthMiddleware extends BaseMiddleware
{
    /**
     * Class AuthMiddleware
     *
     * @throws Exception
     */
    public function handle()
    {
        $response = false;

        if(!$response) {
            throw new ForbiddenException();
        }

    }
}