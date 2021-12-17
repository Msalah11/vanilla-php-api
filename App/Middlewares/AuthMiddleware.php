<?php

namespace App\Middlewares;

use App\Exceptions\ForbiddenException;
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
        $response = true;

        if (!$response) {
            throw new ForbiddenException();
        }

    }
}