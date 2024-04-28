<?php

namespace App\Router;

use App\Http\Request\Request;
use App\Exceptions\MethodNotAllowedException;
use App\Exceptions\ConfigFileNotFoundException;

class Router implements RouterInterface
{
    private array $routes = [];

    private const CONFIG_PATH = CONFIG . '/routes.php';

    private function findRoute(string $uri): ?array
    {
        $route = array_filter($this->routes, fn ($route) => $route['uri'] === $uri);
        return isset($route[0]) ? $route[0] : null;
    }

    public function registerRoutes(): void
    {
        if ($this->isValidConfigFile()) {
            $this->routes = require_once(self::CONFIG_PATH);
        }
    }

    public function isValidConfigFile(): bool
    {
        if (file_exists(self::CONFIG_PATH)) {
            return true;
        } else {
            throw new ConfigFileNotFoundException();
        }
    }

    public function dispatch(Request $request): ?array
    {
        $route = $this->findRoute($request->getUri());

        if (isset($route)) {
            $this->validateRequestMethod($route['methods'], $request->getMethod());

            return [$route['handler'][0], $route['handler'][1]];
        }

        return null;
    }

    public function validateRequestMethod(array $allowedMethods, $requestMethod): void
    {
        if (!in_array($requestMethod, $allowedMethods)) {
            throw new MethodNotAllowedException("Request method $requestMethod is not allowed for the route.");
        }
    }
}