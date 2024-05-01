<?php

declare(strict_types=1);

namespace App\Http\Response;

use App\Http\Response\Response;

class JsonResponse extends Response
{
    public function __construct(
        protected mixed $content = '',
        protected int $statusCode = 200,
        protected array $headers = [],
    ) {
        parent::__construct($content, $statusCode, $headers);

        $this->setHeader('Content-Type', 'application/json');

        $content = $content ? $content : new \ArrayObject();

        $this->setJson($content);
    }

    public function setJson(mixed $json): void
    {
        $this->content = json_encode($json);
    }
}