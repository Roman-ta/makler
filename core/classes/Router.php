<?php

namespace Makler;
class Router
{
    private array $routes = [];

    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    public function match(string $url): void
    {
        $url = trim($url, "/");
        if (isset($this->routes[$url])) {
            $url .= '.php';
            $this->run($url);
        } else if (!$url) {
            $this->run('app.php');
        } else {
            $this->handleNotFound(404);
        }
    }

    private function run(string $url): void
    {
        $file = CONTROLLERS . '/' . $url;
        if (file_exists($file)) {
            require CONTROLLERS . '/' . $url;
        } else {
            $this->handleNotFound(404);
        }
    }

    public function handleNotFound(int $errorCode): void
    {
        http_response_code($errorCode);
        require VIEWS . "/errors/{$errorCode}.php";
    }
}