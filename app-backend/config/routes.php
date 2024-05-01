<?php

declare(strict_types=1);

use App\Router\Route;
use App\Controller\ContactController;

return [
    Route::get(
        'view_contacts',
        '/',
        [ContactController::class, 'index']
    ),
    Route::post(
        'add_contact',
        '/contact',
        [ContactController::class, 'create']
    ),
    Route::delete(
        'delete_contact',
        '/contact',
        [ContactController::class, 'delete']
    ),
];