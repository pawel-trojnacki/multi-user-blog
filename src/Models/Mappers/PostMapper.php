<?php

namespace App\Models\Mappers;

use PDO;
use App\Core\App;
use App\Models\Entities\PostEntity;

class PostMapper
{
    public function fetchAllByUserId(string $userId, int $offset): array
    {
        $pdo = App::$database->connection();
        $statement = $pdo->prepare('
            SELECT post_id, post_title, post_description, post_author,
            post_views, post_image, post_category, post_content,
            DATE_FORMAT(post_create_date, "%M %d, %Y") AS post_date
            FROM posts
            WHERE post_author = :user
            ORDER BY post_create_date DESC
            LIMIT 4 OFFSET :offset
        ');
        $statement->bindParam(':user', $userId, PDO::PARAM_STR);
        $statement->bindParam(':offset', $offset, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function fetchTrendingWithAuthor(): array
    {
        $pdo = App::$database->connection();
        $statement = $pdo->prepare('
            SELECT post_id, post_title, post_description, post_author,
            post_views, post_image, post_category, post_content,
            DATE_FORMAT(post_create_date, "%M %d, %Y") AS post_date,
            user_name
            FROM posts INNER JOIN users
            ON post_author = user_id
            ORDER BY
            UNIX_TIMESTAMP( post_create_date ) + post_views * 86400
            DESC LIMIT 6;
        ');
        $statement->execute();
        return $statement->fetchAll();
    }

    public function fetchAllWithAuthor(int $offset): array
    {
        $pdo = App::$database->connection();
        $statement = $pdo->prepare('
            SELECT post_id, post_title, post_description, post_author,
            post_views, post_image, post_category, post_content,
            DATE_FORMAT(post_create_date, "%M %d, %Y") AS post_date,
            user_name
            FROM posts INNER JOIN users
            ON post_author = user_id
            ORDER BY post_create_date
            DESC LIMIT 4 OFFSET :offset;
        ');
        $statement->bindParam(':offset', $offset, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function fetchAllWithAuthorByCategoryId(string $categoryId, int $offset): array
    {
        $pdo = App::$database->connection();
        $statement = $pdo->prepare('
            SELECT post_id, post_title, post_description, post_author,
            post_views, post_image, post_category, post_content,
            DATE_FORMAT(post_create_date, "%M %d, %Y") AS post_date,
            user_name
            FROM posts INNER JOIN users
            ON post_author = user_id
            WHERE post_category = :category
            ORDER BY post_create_date
            DESC LIMIT 4 OFFSET :offset
        ');
        $statement->bindParam(':category', $categoryId, PDO::PARAM_INT);
        $statement->bindParam(':offset', $offset, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function fetchAllPostsNumber(): int
    {
        $pdo = App::$database->connection();
        $statement = $pdo->prepare('SELECT COUNT(post_id) FROM posts;');
        $statement->execute();
        return $statement->fetchColumn();
    }

    public function fetchPostsNumberByCategoryId(string $categoryId): int
    {
        $pdo = App::$database->connection();
        $statement = $pdo->prepare('
          SELECT COUNT(post_id) FROM posts
          WHERE post_category = ?
        ');
        $statement->execute([$categoryId]);
        return $statement->fetchColumn();
    }

    public function fetchPostsNumberByUserId(string $userId): int
    {
        $pdo = App::$database->connection();
        $statement = $pdo->prepare('
          SELECT COUNT(post_id) FROM posts
          WHERE post_author = ?
        ');
        $statement->execute([$userId]);
        return $statement->fetchColumn();
    }

    public function fetchOneByIdWithAuthor(string $postId): array|false
    {
        $pdo = App::$database->connection();
        $statement = $pdo->prepare('
            SELECT post_id, post_title, post_description, post_author,
            post_views, post_image, post_category, post_content,
            DATE_FORMAT(post_create_date, "%M %d, %Y") AS post_date,
            user_name, user_description, user_avatar
            FROM posts INNER JOIN users
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

    public function updateById(PostEntity $post, string $postId): void
    {
        $pdo = App::$database->connection();
        $statement = $pdo->prepare('
            UPDATE posts SET
            post_title = ?,
            post_description = ?,
            post_content = ?,
            post_image = ?,
            post_category = ?
            WHERE post_id = ?
        ');

        $statement->execute([
            $post->title,
            $post->description,
            $post->content,
            $post->image,
            $post->category,
            $postId
        ]);
    }

    public function updateViewsById(string $postId): void
    {
        $pdo = App::$database->connection();
        $statement = $pdo->prepare('
            UPDATE posts SET post_views = post_views + 1
            WHERE post_id = ?;
        ');
        $statement->execute([$postId]);
    }

    public function deleteById(string $postId): void
    {
        $pdo = App::$database->connection();
        $statement = $pdo->prepare('
            DELETE FROM posts WHERE post_id = ?;
        ');
        $statement->execute([$postId]);
    }
}
