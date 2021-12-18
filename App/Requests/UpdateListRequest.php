<?php

namespace App\Requests;

class UpdateListRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'id' => [self::RULE_REQUIRED],
            'name' => [self::RULE_REQUIRED, self::RULE_MAX => 100],
        ];
    }
}