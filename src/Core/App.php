<?php

namespace App\Core;

use App\Controllers\NotFoundController;

class App
{
    public static Database $database;
    public static Session $session;
    public static Request $request;
    public static Response $response;

    private array $routes = [];

    public function __construct()
    {
        self::$database = new Database();
        self::$session = new Session();
        self::$request = new Request();
        self::$response = new Response();

        self::$session->start();
    }

    public function get(string $path, callable|array $handler): void
    {
        $this->routes[Request::GET][$path] = $handler;
    }

    public function post(string $path, callable|array $handler): void
    {
        $this->routes[Request::POST][$path] = $handler;
    }

    public function run(): void
    {
        $method = self::$request->method();
        $path = self::$request->path();

        $handler = $this->routes[$method][$path] ?? null;

        if ($handler) {
            if (is_array($handler)) {
                $instance = new $handler[0];
                $handler[0] = $instance;
            }
            call_user_func($handler);
        } else {
            $notFound = new NotFoundController();
            self::$response->setStatusCode(Response::NOT_FOUND_CODE);
            $notFound->index();
        }
    }
}
