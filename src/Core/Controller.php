<?php

namespace App\Core;

abstract class Controller
{
    protected function render(string $view, array $data = [], string $layout = 'main'): void
    {
        extract($data);
        $viewsPath = dirname(__DIR__, 2) . '/views';
        $contentFile = "{$viewsPath}/{$view}.php";

        if (!file_exists($contentFile)) {
            die("View [{$view}] không tồn tại!");
        }

        ob_start();
        require $contentFile;
        $content = ob_get_clean();

        if ($layout === 'none') {
            echo $content;
            return;
        }

        $layoutFile = "{$viewsPath}/layouts/{$layout}.php";
        if (file_exists($layoutFile)) {
            require $layoutFile;
        } else {
            echo $content;
        }
    }

    protected function json(mixed $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    protected function redirect(string $url): void
    {
        header("Location: {$url}");
        exit;
    }

    protected function setFlash(string $type, string $message): void
    {
        Auth::initSession();
        $_SESSION["flash_{$type}"] = $message;
    }
}
