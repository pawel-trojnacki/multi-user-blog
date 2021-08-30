<?php

namespace App\Controllers;

use App\Core\App;
use App\Middlewares\AuthMiddleware;
use App\Models\Services\CategoryService;

abstract class MainControllerAbstract
{

    protected AuthMiddleware $authMiddleware;
    protected CategoryService $categoryService;

    public function __construct()
    {
        $this->authMiddleware = new AuthMiddleware();
        $this->categoryService = new CategoryService();
    }

    public function render(string $view, array $args = [], array $options = []): void
    {
        $isAuthenticated = $this->authMiddleware->isAuthenticated();
        $categories = $this->categoryService->getAllCategories();

        $layoutArgs = ['isAuthenticated' => $isAuthenticated, 'categories' => $categories];

        App::$response->render($view, $args, $layoutArgs, $options);
    }
}
