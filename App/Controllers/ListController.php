<?php

namespace App\Controllers;

use App\Requests\{AddItemRequest, DeleteListRequest, StoreListRequest, UpdateListRequest};
use App\Middlewares\AuthMiddleware;
use App\Models\{Category, Item, User};
use App\Resources\ListResource;
use App\Traits\HttpResponse;

class ListController extends BaseController
{
    use HttpResponse;

    private Category $list;
    private Item $item;
    private User $user;
    private StoreListRequest $storeListRequest;
    private UpdateListRequest $updateListRequest;
    private DeleteListRequest $deleteListRequest;
    private AddItemRequest $addItemRequest;

    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware());

        $this->list = new Category();
        $this->item = new Item();
        $this->user = new User();
        $this->storeListRequest = new StoreListRequest();
        $this->updateListRequest = new UpdateListRequest();
        $this->deleteListRequest = new DeleteListRequest();
        $this->addItemRequest = new AddItemRequest();
    }

    public function index()
    {
        $lists = $this->list->all();

        return $this->sendSuccess((new ListResource())->collection($lists));
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

    public function find($id)
    {
        $list = $this->list->find(['id' => $id]);

        if (empty($list)) {
            return $this->sendError("No List Founded with this id {$id}");
        }

        if ($list->user_id != authedUser()->id) {
            return $this->sendError('You don\'t have permission to access this page', 403);
        }

        $list->user = $this->user->find(['id' => $list->user_id]);
        $list->items = $this->item->findAll(['list_id' => $id]);

        return $this->sendSuccess((new ListResource())->resource($list));
    }

    public function update($id)
    {
        $list = $this->list->find(['id' => $id]);

        $this->validateRequest('updateListRequest');
        $requests = $this->updateListRequest->modifiedData();

        if (empty($list)) {
            return $this->sendError("No List Founded with this id {$id}");
        }

        if ($list->user_id != authedUser()->id) {
            return $this->sendError('You don\'t have permission to access this page', 403);
        }

        $update = $this->list->update(['id' => $list->id], $requests);

        if (!$update) {
            return $this->sendError('There is an error happend. please try again later');
        }

        $this->sendSuccess([], 'List Updated Successfully');
    }

    public function delete()
    {
        $this->validateRequest('deleteListRequest');
        $requests = $this->deleteListRequest->getBody();

        $deleteItems = $this->item->delete(['list_id' => $requests['id']]);

        $deleteList = $this->list->delete($requests);

        if (!$deleteItems || !$deleteList) {
            return $this->sendError('There is an error happend. please try again later');
        }

        $this->sendSuccess([], 'List Deleted Successfully');
    }

    public function addItem($id)
    {
        $list = $this->list->find(['id' => $id]);

        $this->validateRequest('addItemRequest');
        $requests = $this->addItemRequest->modifiedData($id);

        if (empty($list)) {
            return $this->sendError("No List Founded with the id {$id}");
        }

        if ($list->user_id != authedUser()->id) {
            return $this->sendError('You don\'t have permission to access this page', 403);
        }

        $item = $this->item->create($requests);

        $this->sendSuccess($item, 'Item Stored Successfully');
    }

    private function validateRequest($request)
    {
        $validation = $this->{$request}->validation();

        if (!empty($validation)) {
            $this->sendValidationError($validation);
            die();
        }
    }
}
