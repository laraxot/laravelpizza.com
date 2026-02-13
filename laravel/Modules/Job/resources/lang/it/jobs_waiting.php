<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Lavori in attesa',
        'group' => 'Lavori',
        'icon' => 'heroicon-o-clock',
        'sort' => 30,
    ],
    'label' => 'Lavoro in attesa',
    'plural_label' => 'Lavori in attesa',
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
        'attempts' => [
            'label' => 'Tentativi',
        ],
        'reserved_at' => [
            'label' => 'Riservato il',
        ],
        'available_at' => [
            'label' => 'Disponibile il',
        ],
        'created_at' => [
            'label' => 'Creato il',
        ],
    ],
    'actions' => [
        'process' => [
            'label' => 'Elabora',
        ],
        'retry' => [
            'label' => 'Riprova',
        ],
    ],
];
