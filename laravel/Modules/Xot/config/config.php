<?php

declare(strict_types=1);

return [
    'name' => 'Xot',
    'description' => 'Modulo base con funzionalità core e utilities',
    'icon' => 'xot-icon',
    'navigation' => [
        'enabled' => true,
        'sort' => 110,
    ],
    'routes' => [
        'enabled' => true,
        'middleware' => ['web', 'auth'],
    ],
    'providers' => [
        'Modules\\Xot\\Providers\\XotServiceProvider',
    ],
];
