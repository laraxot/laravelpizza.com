<?php

declare(strict_types=1);

return [
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome del permesso',
            'help' => 'Nome univoco del permesso',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'guard_name' => [
            'label' => 'Guard Name',
            'placeholder' => 'Inserisci il nome del guard',
            'help' => 'Nome del guard per il permesso',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'active' => [
            'label' => 'Attivo',
            'placeholder' => 'Seleziona lo stato',
            'help' => 'Indica se il permesso è attivo',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
            'placeholder' => 'Data di creazione',
            'help' => 'Data di creazione del permesso',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
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
    'label' => 'Permission',
    'plural_label' => 'Permission (Plurale)',
    'actions' => [
        'create' => [
            'label' => 'Crea Permission',
        ],
        'edit' => [
            'label' => 'Modifica Permission',
        ],
        'delete' => [
            'label' => 'Elimina Permission',
        ],
    ],
];
