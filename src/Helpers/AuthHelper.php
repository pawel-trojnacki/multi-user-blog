<?php

namespace App\Helpers;

use App\Core\App;

class AuthHelper
{
    public const USER_ID = 'user_id';
    public const AUTH_REDIRECT_ROUTE = '/login';

    private function notAuthorizedRedirect(): void
    {
        App::$response->redirect(self::AUTH_REDIRECT_ROUTE);
        exit();
    }

    public function getUserId(): string
    {
        return App::$session->getValue(self::USER_ID);
    }

    public function isAuthenticated(): bool
    {
        $userId = $this->getUserId();
        return boolval($userId);
    }

    public function setUserId(string $userId): void
    {
        App::$session->setValue(self::USER_ID, $userId);
    }

    public function protectedRoute(): void
    {
        $userId = $this->getUserId();

        if (!$userId) {
            $this->notAuthorizedRedirect();
            exit();
        }
    }

    public function authorize(string $authorId): void
    {
        $userId = $this->getUserId();

        if (!$userId === $authorId) {
            $this->notAuthorizedRedirect();
            exit();
        }
    }
}
