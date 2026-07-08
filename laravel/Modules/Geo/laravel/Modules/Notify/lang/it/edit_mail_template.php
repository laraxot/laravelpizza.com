<?php

declare(strict_types=1);

return [
    'actions' => [
        'delete' => [
            'label' => 'delete',
        ],
        'cancel' => [
            'label' => 'cancel',
        ],
        'save' => [
            'label' => 'save',
        ],
        'activeLocale' => [
            'label' => 'activeLocale',
        ],
    ],
    'label' => 'Edit Mail Template',
    'plural_label' => 'Edit Mail Template (Plurale)',
    'navigation' => [
        'name' => 'Edit Mail Template',
        'plural' => 'Edit Mail Template',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Edit Mail Template',
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
];
