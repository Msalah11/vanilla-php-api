<?php

namespace App\Models;

class User extends BaseModel
{
    protected string $table = 'users';

    protected array $attributes = [
        'name', 'email', 'password', 'token'
    ];
}