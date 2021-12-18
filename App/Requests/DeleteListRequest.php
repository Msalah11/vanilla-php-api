<?php

namespace App\Requests;

class DeleteListRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'id' => [self::RULE_REQUIRED],
        ];
    }
}