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
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'name' => [
            'label' => 'Nome',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'description' => [
            'label' => 'Descrizione',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'color' => [
            'label' => 'Colore',
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
        'updated_at' => [
            'label' => 'Aggiornato il',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
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
