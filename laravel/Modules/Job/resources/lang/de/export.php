<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Export',
        'group' => 'Exporte',
        'icon' => 'heroicon-o-arrow-down-tray',
        'sort' => 25,
    ],
    'label' => 'Export',
    'plural_label' => 'Exporte',
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
        'exportable_type' => [
            'label' => 'Exportierbarer Typ',
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
        'format' => [
            'label' => 'Format',
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
            'label' => 'Erstellt am',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'completed_at' => [
            'label' => 'Abgeschlossen am',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'export' => [
            'label' => 'Exportieren',
        ],
        'download' => [
            'label' => 'Herunterladen',
        ],
    ],
];
