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

    public function fetchOneByUserId(string $userId): array|false
    {
        $pdo = App::$database->connection();
        $statement = $pdo->prepare('
            SELECT user_name, user_email, user_description, user_avatar FROM users
            WHERE user_id = ?;
        ');
        $statement->execute([$userId]);
        return $statement->fetch();
    }
}
