<?php

declare(strict_types=1);

return [
    'actions' => [
        'save' => [
            'icon' => 'save',
        ],
        'profile' => [
            'icon' => 'profile',
        ],
        'billing' => [
            'icon' => 'billing',
        ],
        'register' => [
            'icon' => 'register',
        ],
        'logout' => [
            'icon' => 'logout',
        ],
    ],
    'navigation' => [
        'name' => 'Tenant Profile',
        'plural' => 'Tenant Profile',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Tenant Profile',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
    'label' => 'Tenant Profile',
    'plural_label' => 'Tenant Profile (Plurale)',
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
