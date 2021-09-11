<?php

namespace App\Controllers;

use App\Core\App;
use App\Helpers\AuthHelper;
use App\Models\Services\CategoryService;

abstract class MainControllerAbstract
{

    protected AuthHelper $authHelper;
    protected CategoryService $categoryService;

    public function __construct()
    {
        $this->authHelper = new AuthHelper();
        $this->categoryService = new CategoryService();
    }

    public function render(string $view, array $args = [], array $options = []): void
    {
        $isAuthenticated = $this->authHelper->isAuthenticated();
        $categories = $this->categoryService->getAllCategories();

        $layoutArgs = ['isAuthenticated' => $isAuthenticated, 'categories' => $categories];

        App::$response->render($view, $args, $layoutArgs, $options);
    }
}
