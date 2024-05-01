<?php

namespace App\Exceptions;

class HttpException extends \Exception
{
    protected int $statusCode = 404;

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }
}
