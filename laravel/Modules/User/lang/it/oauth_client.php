<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'OAuth Clients',
        'group' => '',
        'icon' => 'heroicon-o-key',
        'sort' => 89,
    ],
    'actions' => [
        'logout' => [
            'tooltip' => 'logout',
            'icon' => 'logout',
            'label' => 'logout',
        ],
    ],
    'fields' => [
        'password_client' => [
            'description' => 'password_client',
        ],
    ],
    'label' => 'OAuth Client',
    'plural_label' => 'OAuth Clients',
];
