<?php

declare(strict_types=1);

return [
    'actions' => [
        'delete' => [
            'icon' => 'delete',
        ],
        'cancel' => [
            'icon' => 'ui-cancel',
        ],
        'save' => [
            'icon' => 'ui-save',
        ],
        'logout' => [
            'icon' => 'ui-logout',
        ],
        'profile' => [
            'icon' => 'profile',
        ],
    ],
    'fields' => [
        'password' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
            'label' => 'Password',
        ],
        'email' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
            'label' => 'E-mail',
        ],
        'name' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
            'label' => 'Nome',
        ],
    ],
    'navigation' => [
        'name' => 'Edit User',
        'plural' => 'Edit User',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Edit User',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
    'label' => 'Edit User',
    'plural_label' => 'Edit User (Plurale)',
];
