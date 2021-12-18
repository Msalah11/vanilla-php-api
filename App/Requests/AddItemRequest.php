<?php

namespace App\Requests;

class AddItemRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'list_id' => [self::RULE_REQUIRED],
            'name' => [self::RULE_REQUIRED, self::RULE_MAX => 100],
        ];
    }
}