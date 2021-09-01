<?php

namespace App\Core;

class Request
{
    private const METHOD = 'REQUEST_METHOD';
    private const PATH = 'PATH_INFO';
    public const GET = 'GET';
    public const POST = 'POST';

    public function method(): string
    {
        return $_SERVER[self::METHOD];
    }

    public function path(): string
    {
        return $_SERVER[self::PATH] ?? '/';
    }

    public function body(): array
    {
        $body = [];
        $method = $this->method();

        if ($method === self::POST) {
            foreach ($_POST as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        if ($method === self::GET) {
            foreach ($_GET as $key => $value) {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        return $body;
    }

    public function file(string $name): array
    {
        return $_FILES[$name] ?? [];
    }

    public function json(): object {
        $json = file_get_contents('php://input');
        return json_decode($json);
    }
}
