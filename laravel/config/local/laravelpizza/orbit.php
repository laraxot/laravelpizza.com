<?php

declare(strict_types=1);
use Orbit\Drivers\Json;
use Orbit\Drivers\Markdown;
use Orbit\Drivers\Yaml;

// use Modules\Tenant\Services\TenantService;

return [
    'default' => env('ORBIT_DEFAULT_DRIVER', 'md'),

    'drivers' => [
        'md' => Markdown::class,
        'json' => Json::class,
        'yaml' => Yaml::class,
    ],

    'paths' => [
        'content' => base_path('config/database/content'),
        'cache' => base_path('config'),
    ],
];
