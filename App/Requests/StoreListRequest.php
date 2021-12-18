<?php

namespace App\Requests;

class StoreListRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name' => [self::RULE_REQUIRED, self::RULE_MAX => 100],
        ];
    }

    public function modifiedData(): array
    {
        $request = $this->getBody();

        $request['user_id'] = authedUser()->id;

        return $request;
    }
}