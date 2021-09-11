<?php

namespace App\Controllers;

use App\Core\App;
use App\Models\Services\CommentService;

class CommentController extends MainControllerAbstract
{
    private CommentService $commentService;

    public function __construct()
    {
        parent::__construct();
        $this->commentService = new CommentService();
    }

    public function postComments(): void
    {
        $postId = App::$request->body()['id'];

        $response = $this->commentService->fetchAllByPostId($postId);

        App::$response->json($response);
    }

    public function postCommentsNumber(): void
    {
        $postId = App::$request->body()['id'];

        $num = $this->commentService->fetchCommentsNumberByPostId($postId);

        App::$response->json(['comments_number' => $num]);
    }

    public function handleSaveComment(): void
    {
        $userId = $this->authHelper->getUserId();

        if (!$userId) {
            App::$response->json(['notAuthenticated' => true, 'success' => false]);
            exit();
        }

        $body = App::$request->json();

        $errors = $this->commentService->save($body, $userId);

        if (empty($errors)) {
            $comment = $this->commentService->fetchLastCommentByPostId($body->postId);
            App::$response->json(['success' => true, 'comment' => $comment]);
        } else {
            App::$response->json(['success' => false, 'errors' => $errors]);
        }
    }
}
