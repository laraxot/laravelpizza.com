<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Lavoro fallito',
        'group' => 'Lavori falliti',
        'icon' => 'heroicon-o-exclamation-triangle',
        'sort' => 27,
    ],
    'label' => 'Lavoro fallito',
    'plural_label' => 'Lavori falliti',
    'fields' => [
        'id' => [
            'label' => 'ID',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'connection' => [
            'label' => 'Connessione',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'queue' => [
            'label' => 'Coda',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'payload' => [
            'label' => 'Contenuto',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'exception' => [
            'label' => 'Eccezione',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'failed_at' => [
            'label' => 'Fallito il',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'retry' => [
            'label' => 'Riprova',
        ],
        'delete' => [
            'label' => 'Elimina',
        ],
    ],
];
