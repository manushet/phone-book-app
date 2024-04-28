<?php

declare(strict_types=1);

use App\Router\Route;
use App\Controller\ContactController;

return [
    Route::get(
        'view_contacts',
        '/',
        [ContactController::class, 'viewAll']
    ),
    Route::post(
        'add_contact',
        '/contact/{id}',
        [ContactController::class, 'add']
    ),
    Route::delete(
        'delete_contact',
        '/contact/{id}',
        [ContactController::class, 'delete']
    ),
];
