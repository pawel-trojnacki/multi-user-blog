<?php

declare(strict_types=1);

ini_set('display_errors', 'On');
ini_set('display_startup_errors', 'On');
error_reporting(E_ALL);

define('ROOT_DIR', dirname(__DIR__));

require_once ROOT_DIR . '/vendor/autoload.php';

use App\Core\App;

use App\Controllers\AuthController;
use App\Controllers\PostController;

$app = new App();

$app->get('/', function () {
    echo phpinfo();
});

$app->get('/register', [AuthController::class, 'register']);

$app->post('/register', [AuthController::class, 'handleRegister']);

$app->get('/login', [AuthController::class, 'login']);

$app->post('/login', [AuthController::class, 'handleLogin']);

$app->post('/logout', [AuthController::class, 'logout']);

$app->get('/publish', [PostController::class, 'publish']);

$app->post('/publish', [PostController::class, 'handlePublish']);

$app->run();
