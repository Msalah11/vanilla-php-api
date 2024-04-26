<?php

namespace App\Requests;

class UpdateListRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name' => [self::RULE_REQUIRED, self::RULE_MAX => 100],
        ];
    }
}
