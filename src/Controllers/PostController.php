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
        $posts = $this->postService->fetchTrendingWithAuthor();

        $args = ['posts' => $posts, 'categories' => $categories];

        $this->render('home', $args);
    }

    public function posts(): void
    {
        $page = App::$request->page();
        $categoryId = App::$request->body()['category'] ?? '';

        $categories = $this->categoryService->getAllCategoriesAssoc();

        if ($categoryId && array_key_exists($categoryId, $categories)) {
            $title = 'Category: ' . $categories[$categoryId];
            $postsNumber = $this->postService->fetchPostsNumberByCategoryId($categoryId);
            $posts = $this->postService->fetchAllWithAuthorByCategoryId($categoryId, $page);
        } else {
            $title = 'All Posts';
            $postsNumber = $this->postService->fetchAllPostsNumber();
            $posts = $this->postService->fetchAllWithAuthor($page);
        }

        $pages = $postsNumber > 4 ? (int)ceil($postsNumber / 4) : 1;

        $args = ['title' => $title, 'category' => $categoryId, 'activePage' => $page, 'posts' => $posts, 'pages' => $pages, 'categories' => $categories];

        $this->render('posts', $args);
    }

    public function userPosts(): void
    {
        $this->authHelper->protectedRoute();

        $userId = $this->authHelper->getUserId();

        $page = App::$request->page();

        $posts = $this->postService->fetchAllByUserId($userId, $page);
        $categories = $this->categoryService->getAllCategoriesAssoc();

        $postsNumber = $this->postService->fetchPostsNumberByUserId($userId);

        $pages = $postsNumber > 4 ? (int)ceil($postsNumber / 4) : 1;

        $args = ['posts' => $posts, 'categories' => $categories, 'activePage' => $page, 'pages' => $pages, 'isAuthor' => true];

        $this->render('user-posts', $args);
    }

    public function search(): void
    {
        $query = App::$request->body()['query'] ?? '';

        if (!$query) {
            App::$response->redirect('/');
        }

        $page = App::$request->page();

        $posts = $this->postService->fetchManyWithAuthorByQuery($page, $query);
        $categories = $this->categoryService->getAllCategoriesAssoc();

        $postsNumber = $this->postService->fetchPostsNumberByQuery($query);

        $pages = $postsNumber > 4 ? (int)ceil($postsNumber / 4) : 1;

        $args = ['query' => $query, 'activePage' => $page, 'posts' => $posts, 'pages' => $pages, 'categories' => $categories];

        $this->render('search', $args);
    }

    public function single(): void
    {
        $postId = App::$request->body()['id'];

        if (!$postId) {
            App::$response->redirect('/');
        }

        $post = $this->postService->fetchOneByIdWithAuthor($postId);

        if (!$post) {
            App::$response->redirect('/');
        }

        $categories = $this->categoryService->getAllCategoriesAssoc();

        $args = ['post' => $post, 'categories' => $categories];

        $this->postService->updateViewsById($postId);

        $this->render('single-post', $args);
    }

    public function publish(): void
    {
        $this->authHelper->protectedRoute();

        $options = $this->categoryService->getAllCategoriesAsValues();

        $args = ['options' => $options];

        $this->render('publish', $args);
    }

    public function handlePublish(): void
    {
        $this->authHelper->protectedRoute();

        $userId = $this->authHelper->getUserId();
        $body = App::$request->body();
        $image = App::$request->file('post_image');

        $errors = $this->postService->save($body, $image, $userId);

        if (empty($errors)) {
            App::$response->redirect('/profile-posts');
        } else {
            $options = $this->categoryService->getAllCategoriesAsValues();

            $args = ['values' => $body, 'errors' => $errors, 'options' => $options];

            $this->render('publish', $args);
        }
    }

    public function update(): void
    {
        $this->authHelper->protectedRoute();

        $postId = App::$request->body()['id'] ?? '';

        if (!$postId) {
            App::$response->redirect('/profile-posts');
        }

        $updatedPost = $this->postService->fetchOneByIdWithAuthor($postId);

        $this->authHelper->authorize($updatedPost['post_author']);

        $options = $this->categoryService->getAllCategoriesAsValues();

        $args = ['options' => $options, 'values' => $updatedPost];

        $this->render('publish', $args);
    }

    public function handleUpdate(): void
    {
        $this->authHelper->protectedRoute();

        $postId = App::$request->body()['post_id'] ?? '';

        if (!$postId) {
            App::$response->redirect('/profile-posts');
        }

        $updatedPost = $this->postService->fetchOneByIdWithAuthor($postId);

        $this->authHelper->authorize($updatedPost['post_author']);

        $body = App::$request->body();
        $image = App::$request->file('post_image');

        $image = $image['name'] ? $image : null;

        $errors = $this->postService->update($updatedPost, $body, $image);

        if (empty($errors)) {
            App::$response->redirect('/profile-posts');
        } else {
            $options = $this->categoryService->getAllCategoriesAsValues();

            $args = ['values' => $body, 'errors' => $errors, 'options' => $options];

            $this->render('publish', $args);
        }
    }

    public function delete()
    {
        $this->authHelper->protectedRoute();

        $postId = App::$request->body()['delete_post_id'] ?? '';

        if (!$postId) {
            App::$response->redirect('/profile-posts');
        }

        $post = $this->postService->fetchOneByIdWithAuthor($postId);

        $this->authHelper->authorize($post['post_author']);

        $this->postService->delete($post);

        App::$response->redirect('/profile-posts');
    }
}
