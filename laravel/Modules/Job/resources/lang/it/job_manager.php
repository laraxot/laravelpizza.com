<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Gestore lavoro',
        'group' => 'Lavori',
        'icon' => 'heroicon-o-cog',
        'sort' => 43,
    ],
    'label' => 'Gestore lavoro',
    'plural_label' => 'Gestori lavoro',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'name' => [
            'label' => 'Nome',
        ],
        'queue' => [
            'label' => 'Coda',
        ],
        'status' => [
            'label' => 'Stato',
        ],
        'last_heartbeat' => [
            'label' => 'Ultimo battito',
        ],
        'created_at' => [
            'label' => 'Creato il',
        ],
        'updated_at' => [
            'label' => 'Aggiornato il',
        ],
    ],
    'actions' => [
        'restart' => [
            'label' => 'Riavvia',
        ],
        'pause' => [
            'label' => 'Pausa',
        ],
        'resume' => [
            'label' => 'Riprendi',
        ],
    ],
];