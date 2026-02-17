<?php

declare(strict_types=1);

return [
    'tab' => [
        'index' => 'Lista',
        'create' => 'Aggiungi Luogo',
        'edit' => 'Modifica Luogo',
    ],
    'label' => 'Places',
    'plural_label' => 'Places (Plurale)',
    'navigation' => [
        'name' => 'Places',
        'plural' => 'Places',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Places',
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
            'label' => 'Crea Places',
        ],
        'edit' => [
            'label' => 'Modifica Places',
        ],
        'delete' => [
            'label' => 'Elimina Places',
        ],
    ],
];
