<?php

declare(strict_types=1);

return [
    'tab' => [
        'index' => 'Indice',
        'create' => 'Crea',
        'edit' => 'Modifica',
    ],
    'label' => 'Translations',
    'plural_label' => 'Translations (Plurale)',
    'navigation' => [
        'name' => 'Translations',
        'plural' => 'Translations',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Translations',
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
            'label' => 'Crea Translations',
        ],
        'edit' => [
            'label' => 'Modifica Translations',
        ],
        'delete' => [
            'label' => 'Elimina Translations',
        ],
    ],
];
