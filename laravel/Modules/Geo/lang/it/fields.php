<?php

declare(strict_types=1);

return [
    'region' => [
        'label' => 'Regione',
        'placeholder' => 'Seleziona una regione',
        'tooltip' => 'Seleziona la regione di appartenenza',
    ],
    'province' => [
        'label' => 'Provincia',
        'placeholder' => 'Seleziona una provincia',
        'tooltip' => 'Seleziona la provincia di appartenenza',
    ],
    'city' => [
        'label' => 'Città',
        'placeholder' => 'Seleziona una città',
        'tooltip' => 'Seleziona la città di appartenenza',
    ],
    'cap' => [
        'label' => 'CAP',
        'placeholder' => 'Seleziona un CAP',
        'tooltip' => 'CAP della città selezionata',
    ],
    'label' => 'Fields',
    'plural_label' => 'Fields (Plurale)',
    'navigation' => [
        'name' => 'Fields',
        'plural' => 'Fields',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Fields',
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
            'label' => 'Crea Fields',
        ],
        'edit' => [
            'label' => 'Modifica Fields',
        ],
        'delete' => [
            'label' => 'Elimina Fields',
        ],
    ],
];
