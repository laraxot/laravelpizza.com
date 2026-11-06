<?php

declare(strict_types=1);

return [
    'name' => 'UI',
    'description' => 'Modulo per la gestione dell\'interfaccia utente e componenti',
    'icon' => 'ui-icon',
    'navigation' => [
        'enabled' => true,
        'sort' => 90,
    ],
    'routes' => [
        'enabled' => true,
        'middleware' => ['web', 'auth'],
    ],
    'providers' => [
        'Modules\\UI\\Providers\\UIServiceProvider',
    ],
];
