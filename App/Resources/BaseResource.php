<?php

namespace App\Resources;

abstract class BaseResource
{
    abstract public function collection($collection);

    abstract public function resource($resource);
}