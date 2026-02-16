<?php

declare(strict_types=1);

return [
    'location' => [
        'title' => 'Selezione Località',
        'submit' => 'Seleziona',
        'messages' => [
            'success' => 'Località selezionata con successo',
            'error' => 'Errore durante la selezione della località',
        ],
    ],
    'label' => 'Widgets',
    'plural_label' => 'Widgets (Plurale)',
    'navigation' => [
        'name' => 'Widgets',
        'plural' => 'Widgets',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Widgets',
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
            'label' => 'Crea Widgets',
        ],
        'edit' => [
            'label' => 'Modifica Widgets',
        ],
        'delete' => [
            'label' => 'Elimina Widgets',
        ],
    ],
];
