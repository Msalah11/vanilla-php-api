<?php

namespace App\Resources;

class ItemResource extends BaseResource
{
    /**
     * Formats a resource into an array.
     *
     * @param mixed $resource The resource to be formatted.
     * @return array The formatted resource as an array.
     */
    protected function formatResource($resource): array
    {
        $item = [
            'id' => $resource->id,
            'name' => $resource->name
        ];

        return $item;
    }
}
