<?php

declare(strict_types=1);

return [
    'name' => 'Tenant',
    'description' => 'Modulo per la gestione multi-tenant dell\'applicazione',
    'icon' => 'heroicon-o-building-office',
    'navigation' => [
        'enabled' => true,
        'sort' => 80,
    ],
    'routes' => [
        'enabled' => true,
        'middleware' => ['web', 'auth'],
    ],
    'providers' => [
        'Modules\\Tenant\\Providers\\TenantServiceProvider',
    ],
];
