<?php

namespace App\Controllers;

use App\Models\Category;
use App\Traits\HttpResponse;

class ListController extends BaseController
{
    use HttpResponse;

    private Category $list;

    public function __construct()
    {
        $this->list = new Category();
    }

}