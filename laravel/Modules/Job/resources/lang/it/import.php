<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Importazione',
        'group' => 'Importazioni',
        'icon' => 'heroicon-o-arrow-up-tray',
        'sort' => 26,
    ],
    'label' => 'Importazione',
    'plural_label' => 'Importazioni',
    'fields' => [
        'id' => [
            'label' => 'ID',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'job_id' => [
            'label' => 'ID lavoro',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'importable_type' => [
            'label' => 'Tipo importabile',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'file_path' => [
            'label' => 'Percorso file',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'status' => [
            'label' => 'Stato',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'created_at' => [
            'label' => 'Creato il',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'completed_at' => [
            'label' => 'Completato il',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'import' => [
            'label' => 'Importa',
        ],
        'upload' => [
            'label' => 'Carica',
        ],
    ],
];
