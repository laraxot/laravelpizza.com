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
        ],
        'job_id' => [
            'label' => 'ID lavoro',
        ],
        'exportable_type' => [
            'label' => 'Tipo esportabile',
        ],
        'file_path' => [
            'label' => 'Percorso file',
        ],
        'format' => [
            'label' => 'Formato',
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
        'export' => [
            'label' => 'Esporta',
        ],
        'download' => [
            'label' => 'Scarica',
        ],
    ],
];
