<?php

namespace App\Models;

class Item extends BaseModel
{
    protected string $table = 'items';

    protected array $attributes = [
        'name', 'list_id'
    ];
}