<?php

declare(strict_types=1);

return [
    'A' => 'A',
    'B' => 'B',
    'C' => 'C',
    'D' => 'D',
    'E' => 'E',
    'label' => 'Xls Import Action',
    'plural_label' => 'Xls Import Action (Plurale)',
    'navigation' => [
        'name' => 'Xls Import Action',
        'plural' => 'Xls Import Action',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Xls Import Action',
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
            'label' => 'Crea Xls Import Action',
        ],
        'edit' => [
            'label' => 'Modifica Xls Import Action',
        ],
        'delete' => [
            'label' => 'Elimina Xls Import Action',
        ],
    ],
];
