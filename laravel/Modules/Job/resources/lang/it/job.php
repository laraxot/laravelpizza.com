<?php

declare(strict_types=1);

return [
    'actions' => [
        'create' => [
            'label' => 'Crea',
        ],
        'logout' => [
            'tooltip' => 'Disconnetti',
            'icon' => 'heroicon-o-arrow-left-on-rectangle',
            'label' => 'Disconnetti',
        ],
        'cancel' => [
            'tooltip' => 'Annulla',
        ],
        'reorderRecords' => [
            'tooltip' => 'Riordina record',
        ],
    ],
    'fields' => [
        'edit' => [
            'label' => 'Modifica',
        ],
        'payload' => [
            'label' => 'Contenuto',
        ],
        'id' => [
            'label' => 'ID',
        ],
        'queue' => [
            'label' => 'Coda',
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
    'navigation' => [
        'sort' => 58,
        'icon' => 'heroicon-o-cog',
        'group' => 'Lavori',
        'label' => 'Lavoro',
    ],
    'label' => 'Lavoro',
    'plural_label' => 'Lavori',
];