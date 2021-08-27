<?php

namespace App\Models\Entities;

class PostEntity
{
    public function __construct(
        private string $title,
        private string $description,
        private string $content,
        private string $image,
        private string $category,
        private string $author
    ) {
    }

    public function title(): string
    {
        return $this->title;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function content(): string
    {
        return $this->content;
    }

    public function image(): string
    {
        return $this->image;
    }

    public function category(): string
    {
        return $this->category;
    }

    public function author(): string
    {
        return $this->author;
    }
}
