<?php

declare(strict_types=1);

return [
    'modules_overview' => [
        'title' => 'Moduli Disponibili',
        'description' => 'Seleziona un modulo per accedere alla sua amministrazione',
        'empty' => [
            'title' => 'Nessun modulo disponibile',
            'description' => 'Non hai accesso a nessun modulo amministrativo.',
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
            'helper_text' => '',
            'description' => '',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'updated_at' => [
            'label' => 'Ultima Modifica',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
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
