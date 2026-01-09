<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Wartende Aufträge',
        'group' => 'Aufträge',
        'icon' => 'heroicon-o-clock',
        'sort' => 30,
    ],
    'label' => 'Wartender Auftrag',
    'plural_label' => 'Wartende Aufträge',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'connection' => [
            'label' => 'Verbindung',
        ],
        'queue' => [
            'label' => 'Warteschlange',
        ],
        'payload' => [
            'label' => 'Nutzlast',
        ],
        'attempts' => [
            'label' => 'Versuche',
        ],
        'status' => [
            'label' => 'Status',
        ],
        'display_name' => [
            'label' => 'Anzeigename',
        ],
        'reserved_at' => [
            'label' => 'Reserviert Am',
        ],
        'available_at' => [
            'label' => 'Verfügbar Am',
        ],
        'created_at' => [
            'label' => 'Erstellt Am',
        ],
    ],
    'actions' => [
        'process' => [
            'label' => 'Verarbeiten',
        ],
        'retry' => [
            'label' => 'Wiederholen',
        ],
    ],
];
