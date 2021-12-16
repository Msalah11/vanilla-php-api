<?php

namespace App\Exceptions;

use Exception;

class NotFoundException extends Exception
{
    protected string $message = '404';
    protected $code = 404;
}