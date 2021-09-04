<?php

namespace App\Models\Services;

use App\Models\Entities\CommentEntity;
use App\Models\Mappers\CommentMapper;

class CommentService
{
    private ValidationService $validationService;
    private CommentMapper $commentMapper;

    public function __construct()
    {
        $this->validationService = new ValidationService();
        $this->commentMapper = new CommentMapper();
    }

    public function fetchAllByPostId(string $postId): array
    {
        return $this->commentMapper->fetchAllByPost($postId);
    }

    public function fetchCommentsNumberByPostId(string $postId): int
    {
        return $this->commentMapper->fetchCommentsNumberByPost($postId);
    }

    public function fetchLastCommentByPostId(string $postId): array
    {
        return $this->commentMapper->fetchLastCommentByPostId($postId);
    }

    public function save(object $body, string $userId): array
    {
        $content = $body->content;
        $postId = $body->postId;

        $errors = $this->validationService->validate([
            'content' => [$content, [
                ValidationService::RULE_REQUIRED,
                [ValidationService::RULE_MIN, 10],
                [ValidationService::RULE_MAX, 4000]
            ]],
        ]);

        if (!empty($errors)) {
            return $errors;
        }

        $comment = new CommentEntity($content, $userId, $postId);

        $this->commentMapper->save($comment);

        return $errors;
    }
}
