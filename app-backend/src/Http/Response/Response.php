<?php

declare(strict_types=1);

namespace App\Http\Response;

class Response
{
    public function __construct(
        protected mixed $content = '',
        protected int $statusCode = 200,
        protected array $headers = [],
    ) {
        http_response_code($this->statusCode);
    }

    public function send(): void
    {
        echo $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setHeader(string $headerName, string $headerValue): static
    {
        $this->headers[$headerName] = $headerValue;

        header("{$headerName}: {$headerValue}; charset=utf-8");

        return $this;
    }
}