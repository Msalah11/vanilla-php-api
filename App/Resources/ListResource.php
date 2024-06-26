<?php

namespace App\Resources;

class ListResource extends BaseResource
{
    /**
     * Formats a resource into an array.
     *
     * @param mixed $resource The resource to be formatted.
     * @return array The formatted resource as an array.
     */
    protected function formatResource($resource): array
    {
        $list = [
            'id' => $resource->id,
            'name' => $resource->name
        ];

        if (isset($resource->user))
            $list['user'] = (new UserResource())->resource($resource->user);

        if (isset($resource->items))
            $list['items'] = (new ItemResource())->collection($resource->items);

        return $list;
    }
}
