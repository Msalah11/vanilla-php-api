<?php

namespace App\Requests;

class LoginRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name' => [self::RULE_REQUIRED],
        ];
    }

}