<?php

namespace App\Exceptions;

class ConfigFileNotFoundException extends HttpException
{
    protected $message = "Config file not found. Unable to proceed running the application";

    protected int $statusCode = 405;
}
