<?php

namespace App\Requests;

class RestPasswordRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
        ];
    }
}