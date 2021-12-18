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
        $user = authedUser();
        $token = $this->bearerToken();

        if( (empty($token) || !$this->isJwtValid($token)) || (empty($user) || $token != $user->token) ) {
            throw new ForbiddenException();
        }

    }
}