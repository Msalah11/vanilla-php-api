<?php

namespace App\Controllers;

use App\Middlewares\AuthMiddleware;
use App\Models\Category;
use App\Traits\HttpResponse;

class ListController extends BaseController
{
    use HttpResponse;

    private Category $list;

    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware());

        $this->list = new Category();
    }


}