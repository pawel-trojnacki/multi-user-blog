<?php

namespace App\Models\Entities;

class UserEntity
{
    public function __construct(
        private string $username,
        private string $email,
        private string $password
    ) {
    }

    public function username(): string
    {
        return $this->username;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function password(): string
    {
        return $this->password;
    }
}
