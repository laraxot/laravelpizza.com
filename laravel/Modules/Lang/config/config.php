<?php

declare(strict_types=1);

return [
    'name' => 'Lang',
    'description' => 'Modulo per la gestione delle traduzioni e localizzazioni',
    'icon' => 'heroicon-o-language',
    'navigation' => [
        'enabled' => true,
        'sort' => 50,
    ],
    'routes' => [
        'enabled' => true,
        'middleware' => ['web', 'auth'],
    ],
    'providers' => [
        'Modules\\Lang\\Providers\\LangServiceProvider',
    ],
];
