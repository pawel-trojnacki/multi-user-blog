<?php

namespace App\Controllers;

use App\Core\App;

class PostController extends MainControllerAbstract
{
    public function publish(): void
    {
        $this->authMiddleware->protectedRoute();

        $options = $this->categoryService->getAllCategoriesAsValues();
        $args = ['options' => $options];
        $this->render('publish', $args);
    }

    public function handlePublish(): void
    {
        $this->authMiddleware->protectedRoute();

        $body = App::$request->body();

        echo '<pre>';
        print_r($body);
        echo '</pre>';

        $content = htmlspecialchars_decode($body['content']);

        echo $content;
    }
}
