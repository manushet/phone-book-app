<?php

declare(strict_types=1);

namespace App\Http\Response;

use App\Http\Response\Response;

class JsonResponse extends Response
{
    public function __construct(
        private mixed $content = '',
        private int $statusCode = 200,
        private array $headers = [],
    ) {
        parent::__construct('', $statusCode, $headers);

        $this->setHeader('Content-Type', 'application/json');

        $content ??= new \ArrayObject();

        $this->setJson($content);
    }

    public function setJson(string $json): void
    {
        $this->content = $json;
    }
}
