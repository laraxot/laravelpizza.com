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
            'label' => 'Reserviert Am',
        ],
        'created_at' => [
            'label' => 'Erstellt Am',
        ],
    ],
    'navigation' => [
        'sort' => 91,
        'icon' => 'heroicon-o-clock',
        'group' => 'System',
        'label' => 'Wartende Aufträge',
    ],
];
