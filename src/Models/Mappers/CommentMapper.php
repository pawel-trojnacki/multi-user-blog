<?php

namespace App\Models\Mappers;

use App\Core\App;

class CommentMapper {
    public function fetchAllByPost(string $postId): array {
        $pdo = App::$database->connection();

        $statement = $pdo->prepare('
            SELECT * FROM comments
            WHERE comment_post = ?
            ORDER BY comment_create_date DESC;
        ');

        $statement->execute([$postId]);

        return $statement->fetchAll();
    }
}