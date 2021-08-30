<?php

namespace App\Models\Services;

use App\Core\App;
use App\Models\Entities\UserEntity;
use App\Models\Mappers\UserMapper;

class AuthService
{
    public const INVALID_CREDENTIALS = 'invalid_credentials';
    public const USER_EXISTS = 'is-existing';

    private ValidationService $validationService;
    private UserMapper $userMapper;

    public function __construct()
    {
        $this->validationService = new ValidationService();
        $this->userMapper = new UserMapper();
    }

    public function register(array $body): array
    {
        $username = $body['username'] ?? '';
        $email = $body['email'] ?? '';
        $password = $body['password'] ?? '';
        $passwordRepeat = $body['password_repeat'] ?? '';

        $errors = $this->validationService->validate([
            'username' => [
                $username,
                [ValidationService::RULE_REQUIRED, [ValidationService::RULE_MIN, 6], [ValidationService::RULE_MAX, 255]]
            ],
            'email' => [
                $email,
                [ValidationService::RULE_REQUIRED, ValidationService::RULE_EMAIL]
            ],
            'password' => [
                $password,
                [ValidationService::RULE_REQUIRED, [ValidationService::RULE_MIN, 8], [ValidationService::RULE_MAX, 255]]
            ],
            'password_repeat' => [
                $passwordRepeat,
                [ValidationService::RULE_REQUIRED, [ValidationService::RULE_MATCH, $password, 'password']]
            ]
        ]);

        if (!empty($errors)) {
            return $errors;
        }

        $existingUser = $this->userMapper->fetchOneByUsernameOrEmail($username, $email);

        if ($existingUser) {
            $errors[self::USER_EXISTS] = true;
            return $errors;
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $user = new UserEntity($username, $email, $passwordHash);

        $this->userMapper->create($user);

        return $errors;
    }

    public function login(array $body): array
    {
        $name = $body['name'] ?? '';
        $password = $body['password'] ?? '';

        $errors = $this->validationService->validate([
            'name' => [
                $name,
                [ValidationService::RULE_REQUIRED]
            ],
            'password' => [
                $password,
                [ValidationService::RULE_REQUIRED]
            ]
        ]);

        if (!empty($errors)) {
            return $errors;
        }

        $user = $this->userMapper->fetchOneByUsernameOrEmail($name, $name);

        if (!$user) {
            $errors[self::INVALID_CREDENTIALS] = true;
            return $errors;
        }

        $passwordHash = $user['user_password'];
        $passwordCorrect = password_verify($password, $passwordHash);

        if (!$passwordCorrect) {
            $errors[self::INVALID_CREDENTIALS] = true;
            return $errors;
        }

        $userId = $user['user_id'];

        App::$session->setValue('user_id', $userId);

        return $errors;
    }

    public function logout(): void
    {
        App::$session->deleteValue('user_id');
    }
}
