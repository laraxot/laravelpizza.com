<?php

declare(strict_types=1);

return [
    'name' => 'User',
    'description' => 'Modulo per la gestione degli utenti e autorizzazioni',
    'icon' => 'heroicon-o-users',
    'navigation' => [
        'enabled' => true,
        'sort' => 100,
    ],
    'routes' => [
        'enabled' => true,
        'middleware' => ['web', 'auth'],
    ],
    'providers' => [
        'Modules\\User\\Providers\\UserServiceProvider',
    ],
];
