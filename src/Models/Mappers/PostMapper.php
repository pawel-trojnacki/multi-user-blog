<?php

namespace App\Models\Mappers;

use App\Core\App;
use App\Models\Entities\PostEntity;

class PostMapper
{
    public function fetchAllWithAuthor(): array
    {
        $pdo = App::$database->connection();
        $statement = $pdo->prepare('
            SELECT post_id, post_title, post_description, post_author,
            post_views, post_image, post_category, post_content,
            DATE_FORMAT(post_create_date, "%M %d, %Y") AS post_date,
            user_name
            FROM posts JOIN users
            ON post_author = user_id
            ORDER BY
            UNIX_TIMESTAMP( post_create_date ) + post_views * 86400
            DESC;
        ');
        $statement->execute();
        return $statement->fetchAll();
    }

    public function fetchOneByIdWithAuthor(string $postId): array|false {
        $pdo = App::$database->connection();
        $statement = $pdo->prepare('
            SELECT post_id, post_title, post_description, post_author,
            post_views, post_image, post_category, post_content,
            DATE_FORMAT(post_create_date, "%M %d, %Y") AS post_date,
            user_name, user_description, user_avatar
            FROM posts JOIN users
            ON post_author = user_id
            WHERE post_id = ?;
        ');
        $statement->execute([$postId]);
        return $statement->fetch();
    }

    public function save(PostEntity $post): void
    {
        $pdo = App::$database->connection();
        $statement = $pdo->prepare('
            INSERT INTO posts
            (post_title, post_description, post_content, post_image, post_author, post_category)
            VALUES (?, ?, ?, ?, ?, ?);
        ');

        $statement->execute([
            $post->title,
            $post->description,
            $post->content,
            $post->image,
            $post->author,
            $post->category
        ]);
    }
}
