<?php

declare(strict_types=1);

return [
    'values' => [
        'yes' => [
            'label' => 'Sì',
            'icon' => 'heroicon-o-check-circle',
            'color' => 'success',
            'description' => 'Valore affermativo',
        ],
        'no' => [
            'label' => 'No',
            'icon' => 'heroicon-o-x-circle',
            'color' => 'danger',
            'description' => 'Valore negativo',
        ],
    ],
    'label' => 'Sì/No',
    'options' => [
        'yes' => 'Sì',
        'no' => 'No',
    ],
    'plural_label' => 'Yes No Enum (Plurale)',
    'navigation' => [
        'name' => 'Yes No Enum',
        'plural' => 'Yes No Enum',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Sì/No',
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
            'label' => 'Crea Yes No Enum',
        ],
        'edit' => [
            'label' => 'Modifica Yes No Enum',
        ],
        'delete' => [
            'label' => 'Elimina Yes No Enum',
        ],
    ],
];
