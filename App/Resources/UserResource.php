<?php

namespace App\Resources;

class UserResource extends BaseResource
{

    public function collection($collection)
    {
        return $collection;
    }

    public function resource($resource): array
    {
        return [
            'id' => $resource->id,
            'name' => $resource->name,
            'email' => $resource->email,
        ];
    }
}