<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Stato lavoro',
        'group' => 'Lavori',
        'icon' => 'heroicon-o-status-online',
        'sort' => 45,
    ],
    'label' => 'Stato lavoro',
    'plural_label' => 'Stati lavoro',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'name' => [
            'label' => 'Nome',
        ],
        'description' => [
            'label' => 'Descrizione',
        ],
        'color' => [
            'label' => 'Colore',
        ],
        'created_at' => [
            'label' => 'Creato il',
        ],
        'updated_at' => [
            'label' => 'Aggiornato il',
        ],
    ],
    'actions' => [
        'update_status' => [
            'label' => 'Aggiorna stato',
        ],
        'assign_to_job' => [
            'label' => 'Assegna al lavoro',
        ],
    ],
];