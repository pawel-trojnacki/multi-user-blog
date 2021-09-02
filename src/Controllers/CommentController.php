<?php

namespace App\Controllers;

use App\Core\App;
use App\Models\Services\CommentService;

class CommentController extends MainControllerAbstract {
    private CommentService $commentService;

    public function __construct()
    {
        parent::__construct();
        $this->commentService = new CommentService();
    }

    public function postComments(): void {
        $postId = App::$request->body()['id'];

        $response = $this->commentService->fetchAllByPost($postId);

        App::$response->json($response);
    }
}