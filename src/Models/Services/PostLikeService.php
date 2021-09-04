<?php

namespace App\Models\Services;

use App\Models\Entities\PostLikeEntity;
use App\Models\Mappers\PostLikeMapper;

class PostLikeService
{
    private PostLikeMapper $postLikeMapper;

    public function __construct()
    {
        $this->postLikeMapper = new PostLikeMapper();
    }

    public function like(string $postId, string $userId): void
    {
        $like = $this->postLikeMapper->fetchOneByPostIdAndUserId($postId, $userId);

        if ($like) {
            $this->postLikeMapper->deleteById($like['post_like_id']);
        } else {
            $newLike = new PostLikeEntity($postId, $userId);
            $this->postLikeMapper->save($newLike);
        }
    }

    public function getLikesNumber(string $postId): string
    {
        return $this->postLikeMapper->fetchLikesNumberByPostId($postId);
    }

    public function getIsLiked(string $postId, string $userId): array|false
    {
        return $this->postLikeMapper->fetchOneByPostIdAndUserId($postId, $userId);
    }
}
