<?php

namespace App\Models\Mappers;

use App\Core\App;
use App\Models\Entities\CommentEntity;

class CommentMapper
{
    public function fetchAllByPost(string $postId): array
    {
        $pdo = App::$database->connection();

        $statement = $pdo->prepare('
            SELECT comment_id, comment_author, comment_post,
            comment_content, user_name, user_avatar,
            DATE_FORMAT(comment_create_date, "%M %d, %Y %k:%i") AS comment_date
            FROM comments
            INNER JOIN users
            ON comment_author = user_id
            WHERE comment_post = ?
            ORDER BY comment_create_date DESC;
        ');

        $statement->execute([$postId]);

        return $statement->fetchAll();
    }

    public function fetchCommentsNumberByPost(string $postId): int
    {
        $pdo = App::$database->connection();

        $statement = $pdo->prepare('
            SELECT COUNT(comment_id)
            FROM comments
            WHERE comment_post = ?;
        ');
        $statement->execute([$postId]);

        return $statement->fetchColumn();
    }

    public function fetchLastCommentByPostId(string $postId): array
    {
        $pdo = App::$database->connection();

        $statement = $pdo->prepare('
            SELECT comment_id, comment_author, comment_post,
            comment_content, user_name, user_avatar,
            DATE_FORMAT(comment_create_date, "%M %d, %Y %k:%i") AS comment_date
            FROM comments
            INNER JOIN users
            ON comment_author = user_id
            WHERE comment_post = ?
            ORDER BY comment_create_date DESC
            LIMIT 1;
        ');

        $statement->execute([$postId]);

        return $statement->fetch();
    }

    public function save(CommentEntity $comment): void
    {
        $pdo = App::$database->connection();

        $statement = $pdo->prepare('
            INSERT INTO comments
            (comment_content, comment_author, comment_post)
            VALUES (?, ?, ?);
        ');

        $statement->execute([$comment->content, $comment->author, $comment->post]);
    }
}
