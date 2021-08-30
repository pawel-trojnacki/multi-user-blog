<?php

namespace App\Core;


class App
{
    public static Database $database;
    public static Session $session;
    public static Request $request;
    public static Response $response;

    private array $routes = [];

    public function __construct(private array|string $notFound)
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
            $notFoundHandler = $this->notFound;
            if (is_array($notFoundHandler)) {
                $instance = new $notFoundHandler[0]();
                $notFoundHandler[0] = $instance;
            }
            self::$response->setStatusCode(Response::NOT_FOUND_CODE);
            call_user_func($notFoundHandler);
        }
    }
}
