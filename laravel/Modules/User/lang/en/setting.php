<?php

declare(strict_types=1);

// SettingPage of the module (BaseSettingPage, Xot). Every key AutoLabelAction reads is written
// here: without it, the first render creates them with raw values.
return [
    'navigation' => [
        'label' => 'Settings',
        'group' => 'Configuration',
        'icon' => 'heroicon-o-cog-6-tooth',
        'sort' => 99,
    ],
    'title' => 'Settings',
    'fields' => [
        'create_personal_team' => [
            'label' => 'Create a personal team for every new user',
            'placeholder' => '',
            'helper_text' => 'When a user is created, a personal team is created too and becomes the current team.',
            'tooltip' => '',
            'description' => '',
        ],
        'passport_enable_password_grant' => [
            'label' => 'Enable the Passport password grant',
            'placeholder' => '',
            'helper_text' => 'Lets apps obtain a token with email and password. Takes effect on the next application start.',
            'tooltip' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'save' => [
            'label' => 'Save',
            'icon' => 'heroicon-o-check',
            'tooltip' => 'Save',
        ],
        'profile' => [
            'label' => 'Profile',
            'icon' => 'heroicon-o-user-circle',
            'tooltip' => 'Profile',
        ],
        'logout' => [
            'label' => 'Log out',
            'icon' => 'heroicon-o-arrow-left-on-rectangle',
            'tooltip' => 'Log out',
        ],
    ],
];
