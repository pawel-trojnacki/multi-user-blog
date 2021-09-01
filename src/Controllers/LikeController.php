<?php

namespace App\Controllers;

use App\Core\App;
use App\Models\Services\PostLikeService;

class LikeController extends MainControllerAbstract {
    private PostLikeService $postLikesService;

    public function __construct()
    {
        parent::__construct();
        $this->postLikesService = new PostLikeService();
    }

    public function postLikesNumber(): void {
        $postId = App::$request->body()['id'];
        
        if(!$postId) {
            $response = ['likes' => 0];
            header('Content-Type: application/json');
            echo json_encode($response);
        } else {
            $likesNumber = $this->postLikesService->getLikesNumber($postId);

            $response = ['likes' => $likesNumber];
            header('Content-Type: application/json');
            echo json_encode($response);
        }
    }

    public function currentPostLike(): void {
        $postId = App::$request->body()['id'];

        $userId = $this->authMiddleware->getUserId();

        $response = ['like' => false];

        if($userId) {
            $like = $this->postLikesService->getIsLiked($postId, $userId);
            if($like) {
                $response['like'] = true;
            }
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function handlePostLike(): void {
        // $body = App::$request->body();
        $json = file_get_contents('php://input');

        $body = json_decode($json);

        $postId = $body->id;

        $userId = $this->authMiddleware->getUserId();

        $response = [];

        if(!$userId) {
            $response['error'] = 'notAuthenticated';
        } else {
            $this->postLikesService->like($postId, $userId);
            $response['success'] = true;
        }
        
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}