<?php

declare(strict_types=1);

use App\Service\ContactService;
use App\Controller\ContactController;

return [
    ContactController::class => [ContactService::class]
];
