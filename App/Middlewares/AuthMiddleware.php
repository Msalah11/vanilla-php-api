<?php

namespace App\Middlewares;

use App\Exceptions\ForbiddenException;
use App\Traits\JWT;
use Exception;

class AuthMiddleware extends BaseMiddleware
{
    use JWT;

    /**
     * Class AuthMiddleware
     *
     * @throws Exception
     */
    public function handle()
    {
        $token = $this->bearerToken();

        if(empty($token) || !$this->isJwtValid($token)) {
            throw new ForbiddenException();
        }

    }
}