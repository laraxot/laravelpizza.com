<?php

declare(strict_types=1);

return [
    'actions' => [
        'create' => [
            'label' => 'create',
            'icon' => 'create',
            'tooltip' => 'create',
        ],
        'createAnother' => [
            'label' => 'createAnother',
            'icon' => 'createAnother',
            'tooltip' => 'createAnother',
        ],
        'cancel' => [
            'label' => 'cancel',
            'icon' => 'cancel',
            'tooltip' => 'cancel',
        ],
        'profile' => [
            'label' => 'profile',
            'icon' => 'profile',
            'tooltip' => 'profile',
        ],
        'logout' => [
            'label' => 'logout',
            'icon' => 'logout',
            'tooltip' => 'logout',
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
        ],
        'created_at' => [
            'label' => 'Data Creazione',
        ],
        'updated_at' => [
            'label' => 'Ultima Modifica',
        ],
    ],
];
