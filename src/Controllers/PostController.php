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
        $categories = $this->categoryService->getAllCategoriesAssoc();
        $posts = $this->postService->fetchAllWithAuthor();

        $args = ['posts' => $posts, 'categories' => $categories];

        $this->render('home', $args);
    }

    public function single(): void {
        $postId = App::$request->body()['id'];
        
        if(!$postId) {
            App::$response->redirect('/');
        }

        $post = $this->postService->fetchOneByIdWithAuthor($postId);
        
        if(!$post) {
            App::$response->redirect('/');
        }

        $categories = $this->categoryService->getAllCategoriesAssoc();

        $args = ['post' => $post, 'categories' => $categories];

        $this->render('single-post', $args);

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
    }
}
