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
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'job_id' => [
            'label' => 'Auftrags-ID',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'importable_type' => [
            'label' => 'Importierbarer Typ',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'file_path' => [
            'label' => 'Dateipfad',
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
        'created_at' => [
            'label' => 'Erstellt Am',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'completed_at' => [
            'label' => 'Abgeschlossen Am',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
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
