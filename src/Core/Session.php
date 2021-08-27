<?php

namespace App\Core;

class Session
{
    public function start(): void
    {
        session_start();
    }

    public function getValue(string $key): mixed
    {
        return $_SESSION[$key] ?? '';
    }

    public function setValue(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function deleteValue(string $key): void
    {
        $_SESSION[$key] = '';
    }
}
