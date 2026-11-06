<?php

declare(strict_types=1);

return [
    'name' => 'Tenant',
    'description' => 'Modulo per la gestione multi-tenant dell\'applicazione',
    'icon' => 'tenant-icon',
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
