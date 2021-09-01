<?php

namespace App\Core;

class Response
{
    public const NOT_FOUND_CODE = 404;
    public const BAD_REQUEST_CODE = 400;
    public const CREATED_CODE = 201;

    public const DEFAULT_LAYOUT = 'main';

    private function layout(string $layout, array $args): string
    {
        extract($args);
        ob_start();
        require_once ROOT_DIR . '/src/Views/layout/' . $layout . '.php';
        return ob_get_clean();
    }

    private function view(string $view, array $args): string
    {
        extract($args);
        ob_start();
        require_once ROOT_DIR . '/src/Views/' . $view . '.php';
        return ob_get_clean();
    }

    public function render(string $view, array $args, array $layoutArgs, array $options): void
    {
        $layoutName = $options['layout'] ?? self::DEFAULT_LAYOUT;
        $layout = $this->layout($layoutName, $layoutArgs);
        $view = $this->view($view, $args);
        echo str_replace('{{content}}', $view, $layout);
    }

    public function setStatusCode(int $code): void
    {
        http_response_code($code);
    }

    public function redirect(string $location): void
    {
        header('Location: ' . $location);
    }

    public function json(array $res) {
        header('Content-Type: application/json');
        echo json_encode($res);
    }

}
