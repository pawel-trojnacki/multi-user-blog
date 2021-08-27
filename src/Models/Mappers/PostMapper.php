<?php

namespace App\Models\Mappers;

use App\Core\App;
use App\Models\Entities\PostEntity;

class PostMapper
{
    public function save(PostEntity $post)
    {
        $pdo = App::$database->connection();
        $statement = $pdo->prepare(
            'INSERT INTO posts
            (post_title, post_description, post_content, post_image, post_author, post_category)
            VALUES (?, ?, ?, ?, ?, ?);'
        );

        $statement->execute([
            $post->title(),
            $post->description(),
            $post->content(),
            $post->image(),
            $post->author(),
            $post->category()
        ]);
    }
}
