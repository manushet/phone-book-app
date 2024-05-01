<?php

declare(strict_types=1);

require_once '../config/init.php';

use App\Kernel\Config;
use App\Kernel\Kernel;
use App\Router\Router;
use App\Kernel\Services;

$router = new Router();

$services = new Services();

Config::loadEnvironment();

$kernel = new Kernel($router, $services);

$response = $kernel->run();

echo ($response->getContent());