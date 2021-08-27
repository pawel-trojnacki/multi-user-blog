<?php

namespace App\Controllers;

use App\Core\App;
use App\Core\Response;
use App\Models\Services\AuthService;

class AuthController extends ControllerAbstract
{
    private AuthService $authService;

    public function __construct()
    {
        parent::__construct();
        $this->authService = new AuthService();
    }


    public function register(): void
    {
        $this->render('register');
    }

    public function login(): void
    {
        $this->render('/login');
    }

    public function handleRegister(): void
    {
        $body = App::$request->body();

        $errors = $this->authService->register($body);

        $args = [];

        if (empty($errors)) {
            $args = ['success' => true];
        } else {
            $args = ['errors' => $errors, 'values' => $body];
            App::$response->setStatusCode(Response::BAD_REQUEST_CODE);
        }

        $this->render('register', $args);
    }

    public function handleLogin(): void
    {
        $body = App::$request->body();

        $errors = $this->authService->login($body);

        if (empty($errors)) {
            App::$response->redirect('/profile');
        } else {
            $args = ['errors' => $errors, 'values' => $body];
            App::$response->setStatusCode(Response::BAD_REQUEST_CODE);
            $this->render('login', $args);
        }
    }

    public function logout(): void
    {
        $this->authService->logout();
        App::$response->redirect('/login');
    }
}
