<?php

namespace App\Requests;

class RegisterRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name' => [self::RULE_REQUIRED, self::RULE_MAX => 50, self::RULE_MIN => 5],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED, self::RULE_MIN => 6],
        ];
    }

    public function modifiedData(): array
    {
        $request = $this->getBody();

        $request['password'] = password_hash($request['password'], PASSWORD_DEFAULT);

        return $request;
    }
}