<?php

namespace App\Resources;

class UserResource extends BaseResource
{
    /**
     * Formats a resource into an array.
     *
     * @param mixed $resource The resource to be formatted.
     * @return array The formatted resource as an array.
     */
    protected function formatResource($resource): array
    {
        $user = [
            'id' => $resource->id,
            'name' => $resource->name,
            'email' => $resource->email,
        ];

        return $user;
    }
}
