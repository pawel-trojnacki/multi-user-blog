<?php

namespace App\Controllers;

use App\Core\App;
use App\Models\Services\PostService;

class PostController extends MainControllerAbstract
{
    private PostService $postService;

    public function __construct()
    {
        parent::__construct();
        $this->postService = new PostService();
    }

    public function home(): void
    {
        $posts = $this->postService->fetchAllWithAuthor();
        $args = ['posts' => $posts];
        $this->render('home', $args);
    }

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

        $userId = $this->authMiddleware->getUserId();
        $body = App::$request->body();
        $image = App::$request->file('image');

        $errors = $this->postService->save($body, $image, $userId);

        if (empty($errors)) {
            App::$response->redirect('/posts');
        } else {
            $options = $this->categoryService->getAllCategoriesAsValues();
            $args = ['values' => $body, 'errors' => $errors, 'options' => $options];
            $this->render('publish', $args);
        }

        // echo '<pre>';
        // print_r($body);
        // echo '</pre>';

        // $content = htmlspecialchars_decode($body['content']);

        // echo $content;
    }
}
