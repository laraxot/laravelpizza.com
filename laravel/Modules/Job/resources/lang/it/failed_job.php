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
        ],
        'connection' => [
            'label' => 'Connessione',
        ],
        'queue' => [
            'label' => 'Coda',
        ],
        'payload' => [
            'label' => 'Contenuto',
        ],
        'exception' => [
            'label' => 'Eccezione',
        ],
        'failed_at' => [
            'label' => 'Fallito il',
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
