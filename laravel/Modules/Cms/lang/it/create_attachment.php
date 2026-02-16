<?php

declare(strict_types=1);

return [
    'actions' => [
        'activeLocale' => [
            'label' => 'activeLocale',
        ],
        'create' => [
            'label' => 'create',
        ],
        'createAnother' => [
            'label' => 'createAnother',
        ],
        'cancel' => [
            'label' => 'cancel',
        ],
    ],
    'label' => 'Create Attachment',
    'plural_label' => 'Create Attachment (Plurale)',
    'navigation' => [
        'name' => 'Create Attachment',
        'plural' => 'Create Attachment',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Create Attachment',
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
];
