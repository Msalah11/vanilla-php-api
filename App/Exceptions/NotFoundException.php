<?php

namespace App\Exceptions;

use Exception;

class NotFoundException extends Exception
{
    protected $message = 'Route Not Found';
    protected $code = 404;
}