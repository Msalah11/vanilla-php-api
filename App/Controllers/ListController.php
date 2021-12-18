<?php

namespace App\Controllers;

use App\Requests\{AddItemRequest, DeleteListRequest, StoreListRequest, UpdateListRequest};
use App\Middlewares\AuthMiddleware;
use App\Models\{Category, Item};
use App\Resources\ListResource;
use App\Traits\HttpResponse;

class ListController extends BaseController
{
    use HttpResponse;

    private Category $list;
    private Item $item;
    private StoreListRequest $storeListRequest;
    private UpdateListRequest $updateListRequest;
    private DeleteListRequest $deleteListRequest;
    private AddItemRequest $addItemRequest;

    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware());

        $this->list = new Category();
        $this->item = new Item();
        $this->storeListRequest = new StoreListRequest();
        $this->updateListRequest = new UpdateListRequest();
        $this->deleteListRequest = new DeleteListRequest();
        $this->addItemRequest = new AddItemRequest();
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
            return $this->sendError("No List Founded with this id {$requests['id']}");
        }

        if($list->user_id != authedUser()->id) {
            return $this->sendError('You don\'t have permission to access this page', 403);
        }

        $update = $this->list->update(['id' => $list->id], ['name' => $requests['name']]);

        if(!$update) {
            return $this->sendError('There is an error happend. please try again later');
        }

        $this->sendSuccess([], 'List Updated Successfully');
    }

    public function delete()
    {
        $this->validateRequest('deleteListRequest');
        $requests = $this->deleteListRequest->getBody();

        $delete = $this->list->delete($requests);

        if(!$delete) {
            return $this->sendError('There is an error happend. please try again later');
        }

        $this->sendSuccess([], 'List Deleted Successfully');
    }

    public function addItem()
    {
        $this->validateRequest('addItemRequest');
        $requests = $this->deleteListRequest->getBody();
        $list = $this->list->find(['id' => $requests['list_id']]);

        if(empty($list)) {
            return $this->sendError("No List Founded with the id {$requests['list_id']}");
        }

        if($list->user_id != authedUser()->id) {
            return $this->sendError('You don\'t have permission to access this page', 403);
        }

        $item = $this->item->create($requests);

        $this->sendSuccess($item, 'Item Stored Successfully');

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