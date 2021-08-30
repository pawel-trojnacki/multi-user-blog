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
            post_image, DATE_FORMAT(post_create_date, "%M %d, %Y %H:%i") AS post_date,
            user_name, post_category
            FROM posts JOIN users
            ON post_author = user_id
            ORDER BY post_create_date;
        ');
        $statement->execute();
        return $statement->fetchAll();
    }

    public function save(PostEntity $post): void
    {
        $pdo = App::$database->connection();
        $statement = $pdo->prepare(
            'INSERT INTO posts
            (post_title, post_description, post_content, post_image, post_author, post_category)
            VALUES (?, ?, ?, ?, ?, ?);'
        );

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
