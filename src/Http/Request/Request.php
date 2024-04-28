<?php

declare(strict_types=1);

namespace App\Http\Request;

class Request
{
    public function __construct(
        private readonly array $params,
        private readonly array $body,
        private readonly array $cookies,
        private readonly array $files,
        private readonly array $server,
    ) {
    }

    private static function UriPathSanitizer(string $uri): string
    {
        return strtok($uri, '?');
    }

    public static function createFromGlobals(): static
    {
        return new static(
            $_GET,
            $_POST,
            $_COOKIE,
            $_FILES,
            $_SERVER
        );
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function getBody(): array
    {
        return $this->body;
    }

    public function getCookies(): array
    {
        return $this->cookies;
    }

    public function getFiles(): array
    {
        return $this->files;
    }

    public function getServer(): array
    {
        return $this->server;
    }

    public function getMethod(): string
    {
        return $this->server['REQUEST_METHOD'];
    }

    public function getUri(): string
    {
        return $this->server['REQUEST_URI'];
    }

    public function getSanitizedServerUri(): string
    {
        return static::UriPathSanitizer($this->server['REQUEST_URI']);
    }
}
