<?php

declare(strict_types=1);

return [
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome del permesso',
            'help' => 'Nome univoco del permesso',
        ],
        'guard_name' => [
            'label' => 'Guard Name',
            'placeholder' => 'Inserisci il nome del guard',
            'help' => 'Nome del guard per il permesso',
        ],
        'active' => [
            'label' => 'Attivo',
            'placeholder' => 'Seleziona lo stato',
            'help' => 'Indica se il permesso è attivo',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
            'placeholder' => 'Data di creazione',
            'help' => 'Data di creazione del permesso',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
        ],
    ],
    'common' => [
        'yes' => 'Sì',
        'no' => 'No',
    ],
    'navigation' => [
        'sort' => 80,
        'label' => 'Permessi',
        'group' => 'Sicurezza',
        'icon' => 'heroicon-o-shield-check',
    ],
    'label' => '',
    'plural_label' => '',
    'actions' => [],
];
