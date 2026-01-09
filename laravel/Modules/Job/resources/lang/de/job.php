<?php

declare(strict_types=1);

return [
    'actions' => [
        'create' => [
            'label' => 'Erstellen',
        ],
        'logout' => [
            'tooltip' => 'Abmelden',
            'icon' => 'logout',
            'label' => 'Abmelden',
        ],
        'cancel' => [
            'tooltip' => 'Abbrechen',
        ],
        'reorderRecords' => [
            'tooltip' => 'Datensätze neu anordnen',
        ],
    ],
    'fields' => [
        'edit' => [
            'label' => 'Bearbeiten',
        ],
        'payload' => [
            'label' => 'Nutzlast',
        ],
        'id' => [
            'label' => 'ID',
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
        'available_at' => [
            'label' => 'Verfügbar am',
        ],
        'created_at' => [
            'label' => 'Erstellt am',
        ],
    ],
    'navigation' => [
        'sort' => 58,
        'icon' => 'heroicon-o-briefcase',
        'group' => 'System',
        'label' => 'Aufträge',
    ],
    'label' => 'Aufträge',
];
