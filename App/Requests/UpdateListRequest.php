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

    public function modifiedData(): array
    {
        $request = $this->getBody();

        $request['updated_at'] = date('Y-m-d H:i:s');

        return $request;
    }
}
