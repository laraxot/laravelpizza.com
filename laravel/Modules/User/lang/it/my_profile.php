<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'My Profile',
        'plural' => 'My Profile',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'My Profile',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
    'label' => 'My Profile',
    'plural_label' => 'My Profile (Plurale)',
    'fields' => [
        'name' => [
            'label' => 'name',
        ],
        'email' => [
            'label' => 'email',
        ],
        'current_password' => [
            'label' => 'current_password',
        ],
        'password_confirmation' => [
            'label' => 'password_confirmation',
        ],
    ],
    'actions' => [
        'updateProfileAction' => [
            'label' => 'updateProfileAction',
        ],
        'updatePasswordAction' => [
            'label' => 'updatePasswordAction',
        ],
        'profile' => [
            'label' => 'profile',
        ],
        'logout' => [
            'label' => 'logout',
        ],
    ],
];
