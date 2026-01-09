<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Import',
        'group' => 'Importe',
        'icon' => 'heroicon-o-arrow-up-tray',
        'sort' => 26,
    ],
    'label' => 'Import',
    'plural_label' => 'Importe',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'job_id' => [
            'label' => 'Auftrags-ID',
        ],
        'importable_type' => [
            'label' => 'Importierbarer Typ',
        ],
        'file_path' => [
            'label' => 'Dateipfad',
        ],
        'status' => [
            'label' => 'Status',
        ],
        'created_at' => [
            'label' => 'Erstellt Am',
        ],
        'completed_at' => [
            'label' => 'Abgeschlossen Am',
        ],
    ],
    'actions' => [
        'import' => [
            'label' => 'Importieren',
        ],
        'upload' => [
            'label' => 'Hochladen',
        ],
        'create' => [
            'label' => 'Erstellen',
        ],
    ],
];
