<?php

namespace App\Core;

class Response
{
    public const NOT_FOUND_CODE = 404;
    public const BAD_REQUEST_CODE = 400;

    public function setStatusCode(int $code): void
    {
        http_response_code($code);
    }

    public function redirect(string $location): void
    {
        header('Location: ' . $location);
    }
}
