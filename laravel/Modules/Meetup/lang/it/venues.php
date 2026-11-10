<?php

declare(strict_types=1);

return [
    'fields' => [
        'name' => [
            'label' => 'Nome',
        ],
        'city' => [
            'label' => 'Città',
        ],
        'address' => [
            'label' => 'Indirizzo',
        ],
        'capacity' => [
            'label' => 'Capienza',
        ],
        'events_count' => [
            'label' => 'Eventi',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Nuovo',
            'tooltip' => 'Nuovo',
        ],
        'edit' => [
            'label' => 'Modifica',
            'tooltip' => 'Modifica',
        ],
        'delete' => [
            'label' => 'Elimina',
            'tooltip' => 'Elimina',
            'icon' => 'delete',
        ],
        'view' => [
            'label' => 'Apri',
            'tooltip' => 'Apri',
        ],
        'layout' => [
            'label' => 'Cambia vista',
            'tooltip' => 'Cambia vista (tabella o schede)',
        ],
    ],
];
