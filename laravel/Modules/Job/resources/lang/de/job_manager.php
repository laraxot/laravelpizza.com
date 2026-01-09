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
            'label' => 'Gestartet Am',
        ],
    ],
    'navigation' => [
        'sort' => 87,
        'icon' => 'heroicon-o-cog-6-tooth',
        'group' => 'System',
        'label' => 'Auftragsmanager',
    ],
];
