<?php

declare(strict_types=1);

return [
    'fields' => [
        'status' => [
            'label' => 'Status',
        ],
        'display_name' => [
            'label' => 'Anzeigename',
        ],
        'queue' => [
            'label' => 'Warteschlange',
        ],
        'attempts' => [
            'label' => 'Versuche',
        ],
        'reserved_at' => [
            'label' => 'Reserviert am',
        ],
        'created_at' => [
            'label' => 'Erstellt am',
        ],
    ],
    'navigation' => [
        'sort' => 91,
        'icon' => 'jobs waiting.navigation',
        'group' => 'jobs waiting.navigation',
        'label' => 'jobs waiting.navigation',
    ],
];
