<?php

declare(strict_types=1);

ini_set('display_errors', 'On');
ini_set('display_startup_errors', 'On');
error_reporting(E_ALL);

define('ROOT_DIR', dirname(__DIR__));
define('IMAGE_UPLOAD_DIR', '/uploads/images');
define('ASSETS_IMAGES_DIR', '/assets/images');

require_once ROOT_DIR . '/vendor/autoload.php';

use App\Core\App;

use App\Controllers\AuthController;
use App\Controllers\CommentController;
use App\Controllers\LikeController;
use App\Controllers\NotFoundController;
use App\Controllers\PostController;
use App\Controllers\UserController;

$app = new App([NotFoundController::class, 'index']);

$app->get('/', [PostController::class, 'home']);

$app->get('/posts', [PostController::class, 'posts']);

$app->get('/post', [PostController::class, 'single']);

$app->get('/publish', [PostController::class, 'publish']);

$app->post('/publish', [PostController::class, 'handlePublish']);

$app->get('/profile-posts', [PostController::class, 'userPosts']);

$app->get('/update-post', [PostController::class, 'update']);

$app->post('/update-post', [PostController::class, 'handleUpdate']);

$app->post('/delete-post', [PostController::class, 'delete']);

$app->get('/register', [AuthController::class, 'register']);

$app->post('/register', [AuthController::class, 'handleRegister']);

$app->get('/login', [AuthController::class, 'login']);

$app->post('/login', [AuthController::class, 'handleLogin']);

$app->post('/logout', [AuthController::class, 'logout']);

$app->get('/user', [UserController::class, 'user']);

$app->get('/profile', [UserController::class, 'profile']);

$app->post('/update-user-description', [UserController::class, 'updateDescription']);

$app->post('/update-user-password', [UserController::class, 'updatePassword']);

$app->post('/update-user-avatar', [UserController::class, 'updateAvatar']);

$app->get('/post-likes', [LikeController::class, 'postLikesNumber']);

$app->get('/post-like', [LikeController::class, 'currentPostLike']);

$app->post('/post-like', [LikeController::class, 'handlePostLike']);

$app->get('/api/post-comments', [CommentController::class, 'postComments']);

$app->get('/api/post-comments-number', [CommentController::class, 'postCommentsNumber']);

$app->post('/api/post-comment', [CommentController::class, 'handleSaveComment']);

$app->run();
