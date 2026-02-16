<?php

declare(strict_types=1);

return [
    'filters' => [
        'apply' => [
            'label' => 'Applica filtri',
            'tooltip' => 'Applica i filtri selezionati',
            'icon' => 'heroicon-o-funnel',
        ],
        'reset' => [
            'label' => 'Reset filtri',
            'tooltip' => 'Ripristina i filtri predefiniti',
            'icon' => 'heroicon-o-x-mark',
        ],
        'open' => [
            'label' => 'Apri filtri',
            'tooltip' => 'Mostra i pannelli di filtro',
            'icon' => 'heroicon-o-adjustments-horizontal',
        ],
    ],
    'columns' => [
        'toggle' => [
            'label' => 'Mostra/Nascondi colonne',
            'tooltip' => 'Gestisci la visibilità delle colonne',
            'icon' => 'heroicon-o-view-columns',
        ],
    ],
    'records' => [
        'reorder' => [
            'label' => 'Riordina record',
            'tooltip' => 'Modifica l\'ordine dei record',
            'icon' => 'heroicon-o-arrows-up-down',
        ],
    ],
    'label' => 'Filament',
    'plural_label' => 'Filament (Plurale)',
    'navigation' => [
        'name' => 'Filament',
        'plural' => 'Filament',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Filament',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
    'fields' => [
        'id' => [
            'label' => 'Identificativo',
            'tooltip' => 'Identificativo univoco del record',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
        ],
        'updated_at' => [
            'label' => 'Ultima Modifica',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Filament',
        ],
        'edit' => [
            'label' => 'Modifica Filament',
        ],
        'delete' => [
            'label' => 'Elimina Filament',
        ],
    ],
];
