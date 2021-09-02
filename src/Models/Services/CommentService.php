<?php

namespace App\Models\Services;

use App\Models\Mappers\CommentMapper;

class CommentService {
    private CommentMapper $commentMapper;

    public function __construct()
    {
        $this->commentMapper = new CommentMapper();
    }

    public function fetchAllByPost(string $postId): array {
        return $this->commentMapper->fetchAllByPost($postId);
    }
}