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
        ],
        'job_id' => [
            'label' => 'Auftrags-ID',
        ],
        'exportable_type' => [
            'label' => 'Exportierbarer Typ',
        ],
        'file_path' => [
            'label' => 'Dateipfad',
        ],
        'format' => [
            'label' => 'Format',
        ],
        'status' => [
            'label' => 'Status',
        ],
        'created_at' => [
            'label' => 'Erstellt am',
        ],
        'completed_at' => [
            'label' => 'Abgeschlossen am',
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
