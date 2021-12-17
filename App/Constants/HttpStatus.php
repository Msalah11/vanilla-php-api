<?php

namespace App\Constants;

final class HttpStatus
{
    const OK = 200;
    const OK_LABEL = '200 OK';

    const BAD_REQUEST = 400;
    const BAD_REQUEST_LABEL = '400 Bad Request';

    const UNPROCESSABLE_ENTITY = 422;
    const UNPROCESSABLE_ENTITY_LABEL = 'Unprocessable Entity';

    const INTERNAL_SERVER_ERROR = 500;
    const INTERNAL_SERVER_ERROR_LABEL = '500 Internal Server Error';

    /**
     * List Of All Status
     * @return array
     */
    public static function list(): array
    {
        return [
            self::OK => self::OK_LABEL,
            self::BAD_REQUEST => self::BAD_REQUEST_LABEL,
            self::UNPROCESSABLE_ENTITY => self::UNPROCESSABLE_ENTITY_LABEL,
            self::INTERNAL_SERVER_ERROR => self::INTERNAL_SERVER_ERROR_LABEL,
        ];
    }

    /**
     * @param $item
     * @return string
     */
    public static function getLabel($item): string
    {
        $types = self::list();
        return $types[$item] ?? 'unknown';
    }
}