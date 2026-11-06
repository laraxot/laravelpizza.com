<?php

declare(strict_types=1);

return [
    'values' => [
        'f' => [
            'label' => 'Femmina',
            'icon' => 'heroicon-o-user',
            'color' => 'pink',
            'description' => 'Genere femminile',
        ],
        'm' => [
            'label' => 'Maschio',
            'icon' => 'heroicon-o-user',
            'color' => 'info',
            'description' => 'Genere maschile',
        ],
    ],
    'label' => 'Genere',
    'options' => [
        'f' => 'Femmina',
        'm' => 'Maschio',
    ],
    'plural_label' => 'Gender Enum (Plurale)',
    'navigation' => [
        'name' => 'Gender Enum',
        'plural' => 'Gender Enum',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Genere',
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
            'label' => 'Crea Gender Enum',
        ],
        'edit' => [
            'label' => 'Modifica Gender Enum',
        ],
        'delete' => [
            'label' => 'Elimina Gender Enum',
        ],
    ],
];
