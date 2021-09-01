<?php

namespace App\Models\Entities;

class PostLikeEntity
{
    public function __construct(
        public string $postId,
        public string $userId,
    ) {
    }
}
