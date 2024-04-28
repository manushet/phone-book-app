<?php

namespace App\Router;

class Route
{
    public static function get(
        string $name,
        string $uri,
        array|callable $handler
    ): array {
        return [
            'methods' => ['GET'],
            'name' => $name,
            'uri' => $uri,
            'handler' => $handler,
        ];
    }

    public static function post(
        string $name,
        string $uri,
        array|callable $handler
    ): array {
        return [
            'methods' => ['POST'],
            'name' => $name,
            'uri' => $uri,
            'handler' => $handler
        ];
    }

    public static function delete(
        string $name,
        string $uri,
        array|callable $handler
    ): array {
        return [
            'methods' => ['DELETE'],
            'name' => $name,
            'uri' => $uri,
            'handler' => $handler
        ];
    }
}
