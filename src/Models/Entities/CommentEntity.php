<?php

namespace App\Models\Entities;

class CommentEntity
{
    public function __construct(
        public string $content,
        public string $author,
        public string $post
    ) {
    }
}
