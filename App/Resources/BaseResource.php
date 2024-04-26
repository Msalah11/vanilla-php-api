<?php

namespace App\Resources;

abstract class BaseResource
{
    /**
     * Formats a single resource.
     *
     * @param mixed $resource The resource to be formatted.
     * @return array The formatted resource.
     */
    abstract protected function formatResource($resource);

    /**
     * Formats a collection of resources.
     *
     * @param array $collection The collection of resources to be formatted.
     * @return array The formatted collection of resources.
     */
    public function collection($collection): array
    {
        $resources = [];
        foreach ($collection as $resource) {
            $resources[] = $this->formatResource($resource);
        }
        return $resources;
    }

    /**
     * Formats a single resource.
     *
     * @param mixed $resource The resource to be formatted.
     * @return array The formatted resource.
     */
    public function resource($resource): array
    {
        return $this->formatResource($resource);
    }
}
