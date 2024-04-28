<?php

declare(strict_types=1);

namespace App\Http\Response;

class Response
{
    public function __construct(
        private mixed $content = '',
        private int $statusCode = 200,
        private array $headers = [],
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

    public function setHeader(string $headerName, string $headerValue): static
    {
        $this->headers[$headerName] = $headerValue;

        return $this;
    }
}
