<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Fehlgeschlagener Auftrag',
        'group' => 'Fehlgeschlagene Aufträge',
        'icon' => 'heroicon-o-exclamation-triangle',
        'sort' => 27,
    ],
    'label' => 'Fehlgeschlagener Auftrag',
    'plural_label' => 'Fehlgeschlagene Aufträge',
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
        'exception' => [
            'label' => 'Ausnahme',
        ],
        'failed_at' => [
            'label' => 'Fehlgeschlagen Am',
        ],
    ],
    'actions' => [
        'retry' => [
            'label' => 'Wiederholen',
        ],
        'delete' => [
            'label' => 'Löschen',
        ],
        'retry_all' => [
            'label' => 'Alle Wiederholen',
        ],
        'delete_all' => [
            'label' => 'Alle Löschen',
        ],
    ],
];
