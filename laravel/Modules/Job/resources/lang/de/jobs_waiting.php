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
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'connection' => [
            'label' => 'Verbindung',
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
        'payload' => [
            'label' => 'Nutzlast',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'attempts' => [
            'label' => 'Versuche',
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
        'display_name' => [
            'label' => 'Anzeigename',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'reserved_at' => [
            'label' => 'Reserviert Am',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'available_at' => [
            'label' => 'Verfügbar Am',
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
