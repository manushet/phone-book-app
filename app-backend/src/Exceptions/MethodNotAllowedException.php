<?php

namespace App\Exceptions;

class MethodNotAllowedException extends HttpException
{
    protected int $statusCode = 405;
}