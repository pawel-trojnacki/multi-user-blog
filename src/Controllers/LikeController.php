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

        $response = [];
        
        if(!$postId) {
            $response['likes'] = 0;
        } else {
            $likesNumber = $this->postLikesService->getLikesNumber($postId);
            $response['likes'] = $likesNumber;
        }

        App::$response->json($response);
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

        App::$response->json($response);
    }

    public function handlePostLike(): void {
        $body = App::$request->json();

        $postId = $body->id;

        $userId = $this->authMiddleware->getUserId();

        $response = [];

        if(!$userId) {
            $response['error'] = 'notAuthenticated';
        } else {
            $this->postLikesService->like($postId, $userId);
            $response['success'] = true;
        }
        
        App::$response->json($response);
    }
}