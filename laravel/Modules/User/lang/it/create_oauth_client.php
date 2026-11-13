<?php

declare(strict_types=1);

return [
    'actions' => [
        'create' => [
            'icon' => 'create',
        ],
        'createAnother' => [
            'icon' => 'createAnother',
        ],
        'cancel' => [
            'icon' => 'cancel',
        ],
        'profile' => [
            'icon' => 'profile',
        ],
        'logout' => [
            'icon' => 'logout',
        ],
    ],
    'navigation' => [
        'name' => 'Create Oauth Client',
        'plural' => 'Create Oauth Client',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Create Oauth Client',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
    'label' => 'Create Oauth Client',
    'plural_label' => 'Create Oauth Client (Plurale)',
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
