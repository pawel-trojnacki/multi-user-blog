<?php

namespace App\Models\Entities;

class PostEntity
{
    public function __construct(
        public string $title,
        public string $description,
        public string $content,
        public string $image,
        public string $category,
        public string $author
    ) {
    }
}
