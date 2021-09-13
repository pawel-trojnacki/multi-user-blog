<?php

namespace App\Models\mappers;

use App\Core\App;
use App\Models\Entities\UserEntity;

class UserMapper
{
    public function create(UserEntity $user): void
    {
        $pdo = App::$database->connection();
        $statement = $pdo->prepare('
            INSERT INTO users
            (user_name, user_email, user_password, user_description, user_avatar)
            VALUES (?, ?, ?, ?, ?);
        ');

        $statement->execute([$user->username, $user->email, $user->password, $user->description, $user->avatar]);
    }

    public function fetchOneByUsernameOrEmail(string $username, string $email): array|false
    {
        $pdo = App::$database->connection();
        $statement = $pdo->prepare('
            SELECT * FROM users
            WHERE user_name = ?
            OR user_email = ?;
        ');
        $statement->execute([$username, $email]);
        return $statement->fetch();
    }

    public function fetchOneById(string $userId): array|false
    {
        $pdo = App::$database->connection();
        $statement = $pdo->prepare('
            SELECT user_id, user_name, user_email, user_description, user_avatar,
            DATE_FORMAT(user_create_date, "%M %Y") AS user_date
            FROM users
            WHERE user_id = ?;
        ');
        $statement->execute([$userId]);
        return $statement->fetch();
    }

    public function updateAvatarById(string $imagePath, string $userId): void
    {
        $pdo = App::$database->connection();
        $statement = $pdo->prepare('
            UPDATE users
            SET user_avatar = ?
            WHERE user_id = ?;
        ');

        $statement->execute([$imagePath, $userId]);
    }

    public function updateDescriptionById(string $description, string $userId): void
    {
        $pdo = App::$database->connection();
        $statement = $pdo->prepare('
            UPDATE users
            SET user_description = ?
            WHERE user_id = ?;
        ');

        $statement->execute([$description, $userId]);
    }

    public function updatePasswordById(string $password, string $userId): void
    {
        $pdo = App::$database->connection();
        $statement = $pdo->prepare('
            UPDATE users
            SET user_password = ?
            WHERE user_id = ?;
        ');

        $statement->execute([$password, $userId]);
    }
}
