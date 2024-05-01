<?php

namespace App\Exceptions;

class RouteNotFoundException extends HttpException
{
    protected int $statusCode = 404;
}