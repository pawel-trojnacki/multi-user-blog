<?php

namespace app\controllers;

use App\Middlewares\AuthMiddleware;
use App\Models\Services\CategoryService;

abstract class ControllerAbstract
{
    public const DEFAULT_LAYOUT = 'main';

    protected AuthMiddleware $authMiddleware;
    protected CategoryService $categoryService;

    public function __construct()
    {
        $this->authMiddleware = new AuthMiddleware();
        $this->categoryService = new CategoryService();
    }

    protected function layout(string $layout): string
    {
        $categories = $this->categoryService->getAllCategories();
        $isAuthenticated = $this->authMiddleware->isAuthenticated();
        ob_start();
        require_once ROOT_DIR . '/src/Views/layout/' . $layout . '.php';
        return ob_get_clean();
    }

    protected function view(string $view, array $args): string
    {
        extract($args);
        ob_start();
        require_once ROOT_DIR . '/src/Views/' . $view . '.php';
        return ob_get_clean();
    }

    public function render(string $view, array $args = [], array $options = []): void
    {
        $layoutName = $options['layout'] ?? self::DEFAULT_LAYOUT;
        $layout = $this->layout($layoutName);
        $view = $this->view($view, $args);
        echo str_replace('{{content}}', $view, $layout);
    }
}
