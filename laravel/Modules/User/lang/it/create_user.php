<?php

declare(strict_types=1);

return [
    'fields' => [
        'name' => [
            'label' => 'name',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'email' => [
            'label' => 'email',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'password' => [
            'label' => 'password',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'create',
        ],
        'createAnother' => [
            'label' => 'createAnother',
        ],
        'cancel' => [
            'label' => 'cancel',
            'icon' => 'cancel',
        ],
        'logout' => [
            'icon' => 'logout',
        ],
    ],
    'navigation' => [
        'name' => 'Create User',
        'plural' => 'Create User',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Create User',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
    'label' => 'Create User',
    'plural_label' => 'Create User (Plurale)',
];
