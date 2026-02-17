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
        'exception' => [
            'label' => 'Ausnahme',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'failed_at' => [
            'label' => 'Fehlgeschlagen Am',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
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
