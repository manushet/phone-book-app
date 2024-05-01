<?php

namespace App\Router;

use App\Http\Request\Request;
use App\Exceptions\RouteNotFoundException;
use App\Exceptions\MethodNotAllowedException;
use App\Exceptions\ConfigFileNotFoundException;

class Router implements RouterInterface
{
    private array $routes = [];

    private const CONFIG_PATH = CONFIG . '/routes.php';

    private function findRoute(string $uri): array
    {
        $routes = array_values(array_filter(
            $this->routes,
            fn ($route) => $route['uri'] === $uri
        ));
        return $routes;
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
        $routes = $this->findRoute($request->getUri());

        if (count($routes) > 0) {
            foreach ($routes as $route) {
                if (in_array($request->getMethod(), $route['methods'])) {
                    return [$route['handler'][0], $route['handler'][1]];
                }
            }

            throw new MethodNotAllowedException("Request method {$request->getMethod()} is not allowed for the route.");
        } else {
            throw new RouteNotFoundException("Route {$request->getUri()} not found.");
        }
    }
}