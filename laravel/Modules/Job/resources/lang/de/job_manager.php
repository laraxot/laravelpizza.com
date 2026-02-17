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
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'name' => [
            'label' => 'Name',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'queue' => [
            'label' => 'Warteschlange',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'status' => [
            'label' => 'Status',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'progress' => [
            'label' => 'Fortschritt',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'started_at' => [
            'label' => 'Gestartet Am',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'last_heartbeat' => [
            'label' => 'Letzter Herzschlag',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'created_at' => [
            'label' => 'Erstellt Am',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'updated_at' => [
            'label' => 'Aktualisiert Am',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
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
