<?php

declare(strict_types=1);

// Colonne e azioni della tabella performers (Tables\PerformersTable).
return [
    'fields' => [
        'name' => [
            'label' => 'Nome',
        ],
        'type' => [
            'label' => 'Ruolo',
        ],
        'company' => [
            'label' => 'Azienda',
        ],
        'email' => [
            'label' => 'Email',
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
