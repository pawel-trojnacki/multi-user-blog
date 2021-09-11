<?php

namespace App\Controllers;

use App\Core\App;
use App\Models\Services\UserService;

class UserController extends MainControllerAbstract
{
    private UserService $userService;

    public function __construct()
    {
        parent::__construct();
        $this->userService = new UserService();
    }

    private function updatingResult(array $errors, array $body): void
    {
        if (empty($errors)) {
            App::$response->redirect('/profile');
        } else {
            $userId = $this->authHelper->getUserId();
            $user = $this->userService->fetchOneById($userId);

            $args = ['user' => $user, 'values' => $body, 'errors' => $errors];
            $this->render('profile', $args);
        }
    }

    public function profile(): void
    {
        $this->authHelper->protectedRoute();

        $userId = $this->authHelper->getUserId();

        $user = $this->userService->fetchOneById($userId);

        $values = ['user_description' => $user['user_description']];

        $args = ['user' => $user, 'values' => $values];

        $this->render('profile', $args);
    }

    public function updateAvatar(): void
    {
        $this->authHelper->protectedRoute();

        $userId = $this->authHelper->getUserId();

        $image = App::$request->file('avatar');

        $errors = $this->userService->updateAvatarById($image, $userId);
        $body = [];

        $this->updatingResult($errors, $body);
    }

    public function updateDescription(): void
    {
        $this->authHelper->protectedRoute();

        $body = App::$request->body();

        $userId = $this->authHelper->getUserId();

        $errors = $this->userService->updateDescriptionById($body, $userId);

        $this->updatingResult($errors, $body);
    }

    public function updatePassword(): void
    {
        $this->authHelper->protectedRoute();

        $body = App::$request->body();

        $userId = $this->authHelper->getUserId();

        $errors = $this->userService->updatePasswordById($body, $userId);

        $this->updatingResult($errors, $body);
    }
}
