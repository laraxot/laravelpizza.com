<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Auftragsmanager',
        'group' => 'Aufträge',
        'icon' => 'heroicon-o-cog',
        'sort' => 43,
    ],
    'label' => 'Auftragsmanager',
    'plural_label' => 'Auftragsmanager',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'name' => [
            'label' => 'Name',
        ],
        'queue' => [
            'label' => 'Warteschlange',
        ],
        'status' => [
            'label' => 'Status',
        ],
        'progress' => [
            'label' => 'Fortschritt',
        ],
        'started_at' => [
            'label' => 'Gestartet Am',
        ],
        'last_heartbeat' => [
            'label' => 'Letzter Herzschlag',
        ],
        'created_at' => [
            'label' => 'Erstellt Am',
        ],
        'updated_at' => [
            'label' => 'Aktualisiert Am',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Erstellen',
        ],
        'restart' => [
            'label' => 'Neustarten',
        ],
        'pause' => [
            'label' => 'Pausieren',
        ],
        'resume' => [
            'label' => 'Fortsetzen',
        ],
    ],
];
