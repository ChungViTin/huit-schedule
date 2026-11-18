<?php

namespace App\Core;

class Router
{
    private array $routes = [];

    public function get(string $path, array $handler): void
    {
        $this->addRoute('GET', $path, $handler);
    }

    public function post(string $path, array $handler): void
    {
        $this->addRoute('POST', $path, $handler);
    }

    private function addRoute(string $method, string $path, array $handler): void
    {
        // Chuyển {id} thành regex pattern (?P<id>[^/]+)
        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', $path);
        $pattern = '#^' . $pattern . '$#';

        $this->routes[] = [
            'method' => $method,
            'pattern' => $pattern,
            'handler' => $handler,
        ];
    }

    public function dispatch(): void
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        // Hỗ trợ method spoofing qua _method trong POST
        if ($method === 'POST' && isset($_POST['_method'])) {
            $method = strtoupper($_POST['_method']);
        }

        foreach ($this->routes as $route) {
            if ($route['method'] === $method && preg_match($route['pattern'], $uri, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                [$controllerClass, $action] = $route['handler'];

                if (!class_exists($controllerClass)) {
                    http_response_code(500);
                    die("Controller [{$controllerClass}] không tồn tại.");
                }

                $controller = new $controllerClass();
                if (!method_exists($controller, $action)) {
                    http_response_code(500);
                    die("Action [{$action}] không tồn tại trên controller [{$controllerClass}].");
                }

                call_user_func_array([$controller, $action], $params);
                return;
            }
        }

        http_response_code(404);
        echo "<h1 style='font-family:sans-serif;text-align:center;margin-top:100px;'>404 - Trang không tồn tại (HUIT Schedule Hub)</h1>";
        echo "<p style='text-align:center;'><a href='/'>Quay lại trang chủ</a></p>";
    }
}
