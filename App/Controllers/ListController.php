<?php

namespace App\Controllers;

use App\Requests\{StoreListRequest, UpdateListRequest};
use App\Middlewares\AuthMiddleware;
use App\Resources\ListResource;
use App\Traits\HttpResponse;
use App\Models\Category;

class ListController extends BaseController
{
    use HttpResponse;

    private Category $list;
    private StoreListRequest $storeListRequest;
    private UpdateListRequest $updateListRequest;

    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware());

        $this->list = new Category();
        $this->storeListRequest = new StoreListRequest();
        $this->updateListRequest = new UpdateListRequest();
    }

    public function create()
    {
        $this->validateRequest('storeListRequest');
        $requests = $this->storeListRequest->modifiedData();
        $list = $this->list->create($requests);

        $this->sendSuccess(
            (new ListResource())->resource($list)
        );
    }

    public function update()
    {
        $this->validateRequest('updateListRequest');
        $requests = $this->updateListRequest->getBody();

        $list = $this->list->find(['id' => $requests['id']]);

        if(empty($list)) {
            $this->sendError("No List Founded with this id {$requests['id']}");
        }
    }

    private function validateRequest($request)
    {
        $validation = $this->{$request}->validation();

        if(!empty($validation)) {
            $this->sendValidationError($validation);
            die();
        }
    }
}