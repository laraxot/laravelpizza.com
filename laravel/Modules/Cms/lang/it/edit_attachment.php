<?php

declare(strict_types=1);

return [
    'actions' => [
        'activeLocale' => [
            'label' => 'activeLocale',
        ],
        'save' => [
            'label' => 'save',
        ],
        'cancel' => [
            'label' => 'cancel',
        ],
    ],
    'label' => 'Edit Attachment',
    'plural_label' => 'Edit Attachment (Plurale)',
    'navigation' => [
        'name' => 'Edit Attachment',
        'plural' => 'Edit Attachment',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Edit Attachment',
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
