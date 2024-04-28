<?php

namespace App\Requests;

class AddItemRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name' => [self::RULE_REQUIRED, self::RULE_MAX => 100],
        ];
    }

    public function modifiedData($listId): array
    {
        $request = $this->getBody();

        $request['list_id'] = $listId;

        return $request;
    }
}
