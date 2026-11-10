<?php

declare(strict_types=1);

// Colonne e azioni della tabella sponsors (Tables\SponsorsTable).
return [
    'fields' => [
        'name' => [
            'label' => 'Nome',
        ],
        'level' => [
            'label' => 'Livello',
        ],
        'website' => [
            'label' => 'Sito web',
        ],
        'order' => [
            'label' => 'Ordine',
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
