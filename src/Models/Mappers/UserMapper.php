<?php

namespace App\Models\mappers;

use App\Core\App;
use App\Models\Entities\UserEntity;

class UserMapper
{
    public function create(UserEntity $user): void
    {
        $pdo = App::$database->connection();
        $statement = $pdo->prepare(
            'INSERT INTO users
            (user_name, user_email, user_password)
            VALUES (?, ?, ?);'
        );

        $statement->execute([$user->username(), $user->email(), $user->password()]);
    }

    public function fetchOneByUsernameOrEmail(string $username, string $email): array|false
    {
        $pdo = App::$database->connection();
        $statement = $pdo->prepare(
            'SELECT * FROM users
            WHERE user_name = ?
            OR user_email = ?;'
        );
        $statement->execute([$username, $email]);
        return $statement->fetch();
    }
}
