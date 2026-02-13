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
        ],
        'job_id' => [
            'label' => 'ID lavoro',
        ],
        'importable_type' => [
            'label' => 'Tipo importabile',
        ],
        'file_path' => [
            'label' => 'Percorso file',
        ],
        'status' => [
            'label' => 'Stato',
        ],
        'created_at' => [
            'label' => 'Creato il',
        ],
        'completed_at' => [
            'label' => 'Completato il',
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
