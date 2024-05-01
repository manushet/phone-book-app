<?php

declare(strict_types=1);

use App\Controller\ContactController;
use App\Repository\ContactRepository;

return [
    ContactController::class => [
        ContactRepository::class
    ],
];