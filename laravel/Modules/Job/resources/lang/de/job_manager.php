<?php

declare(strict_types=1);

return [
    'actions' => [
        'create' => [
            'label' => 'Erstellen',
        ],
    ],
    'fields' => [
        'status' => [
            'label' => 'Status',
        ],
        'name' => [
            'label' => 'Name',
        ],
        'queue' => [
            'label' => 'Warteschlange',
        ],
        'progress' => [
            'label' => 'Fortschritt',
        ],
        'started_at' => [
            'label' => 'Gestartet am',
        ],
    ],
    'navigation' => [
        'sort' => 87,
        'icon' => 'job manager.navigation',
        'group' => 'job manager.navigation',
        'label' => 'job manager.navigation',
    ],
];
