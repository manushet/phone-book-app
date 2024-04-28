<?php

declare(strict_types=1);

require_once '../config/init.php';

use App\Kernel\Kernel;
use App\Router\Router;
use App\Kernel\Services;

$router = new Router();

$services = new Services();

$kernel = new Kernel($router, $services);

$kernel->run();
