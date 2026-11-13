<?php

declare(strict_types=1);

return [
    'name' => 'Activity',
    'description' => 'Modulo per il tracciamento delle attività degli utenti',
    'icon' => 'activity-icon',
    'navigation' => [
        'enabled' => true,
        'sort' => 20,
    ],
    'routes' => [
        'enabled' => true,
        'middleware' => ['web', 'auth'],
    ],
    'providers' => [
        'Modules\\Activity\\Providers\\ActivityServiceProvider',
    ],
];
