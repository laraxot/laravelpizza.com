<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Esportazione',
        'group' => 'Esportazioni',
        'icon' => 'heroicon-o-arrow-down-tray',
        'sort' => 25,
    ],
    'label' => 'Esportazione',
    'plural_label' => 'Esportazioni',
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
        'exportable_type' => [
            'label' => 'Tipo esportabile',
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
        'format' => [
            'label' => 'Formato',
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
        'export' => [
            'label' => 'Esporta',
        ],
        'download' => [
            'label' => 'Scarica',
        ],
    ],
];
