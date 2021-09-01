<?php

namespace App\Models\Mappers;

use App\Core\App;
use App\Models\Entities\PostLikeEntity;

class PostLikeMapper {
    public function fetchCountByPostId(string $postId): string {
        $pdo = App::$database->connection();
        $statement = $pdo->prepare('
            SELECT COUNT(post_like_id) FROM post_likes
            WHERE post_like_post = ?;
        ');

        $statement->execute([$postId]);
        return $statement->fetchColumn();
    }

    public function fetchOneByPostIdAndUserId(string $postId, string $userId): array|false {
        $pdo = App::$database->connection();
        $statement = $pdo->prepare('
            SELECT * FROM post_likes
            WHERE post_like_post = ?
            AND post_like_user = ?;
        ');
        $statement->execute([$postId, $userId]);
        return $statement->fetch();
    }

    public function save(PostLikeEntity $like): void {
        $pdo = App::$database->connection();
        $statement = $pdo->prepare('
            INSERT INTO post_likes
            (post_like_post, post_like_user)
            VALUES (?, ?);
        ');
        $statement->execute([$like->postId, $like->userId]);
    }

    public function deleteById(string $likeId): void {
        $pdo = App::$database->connection();
        $statement = $pdo->prepare('
            DELETE FROM post_likes
            WHERE post_like_id = ?;
        ');
        $statement->execute([$likeId]);
    }
}