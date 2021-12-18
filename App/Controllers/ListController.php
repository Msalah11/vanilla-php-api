<?php

namespace App\Controllers;

use App\Middlewares\AuthMiddleware;
use App\Models\Category;
use App\Requests\StoreListRequest;
use App\Resources\ListResource;
use App\Traits\HttpResponse;

class ListController extends BaseController
{
    use HttpResponse;

    private Category $list;
    private StoreListRequest $storeListRequest;

    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware());

        $this->list = new Category();
        $this->storeListRequest = new StoreListRequest();
    }

    public function create()
    {
        $this->validationCreateList();
        $requests = $this->storeListRequest->modifiedData();
        $list = $this->list->create($requests);

        $this->sendSuccess(
            (new ListResource())->resource($list)
        );
    }

    private function validationCreateList()
    {
        $validation = $this->storeListRequest->validation();

        if(!empty($validation)) {
            $this->sendValidationError($validation);
            die();
        }
    }
}