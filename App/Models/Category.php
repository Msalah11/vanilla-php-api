<?php

namespace App\Models;

class Category extends BaseModel
{
    protected string $table = 'lists';

    protected array $attributes = [
        'id', 'name', 'user_id', 'updated_at'
    ];

    protected array $relations = [
        'items' => 'list_id'
    ];
}
