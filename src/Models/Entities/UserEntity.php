<?php

namespace App\Models\Entities;

class UserEntity
{
    public function __construct(
        public string $username,
        public string $email,
        public string $password,
        public string $description = '',
        public string $avatar = ASSETS_IMAGES_DIR . 'avatar.png',
    ) {
    }
}
