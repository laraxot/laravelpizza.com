<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Settings',
        'group' => 'Configuration',
        'icon' => 'heroicon-o-cog-6-tooth',
        'sort' => 99,
    ],
    'title' => 'Settings',
    'fields' => [
        'pub_theme' => [
            'label' => 'Public site theme',
            'placeholder' => 'Choose a theme',
            'helper_text' => 'Only themes installed in Themes/. Read on every request, no config:cache needed.',
            'tooltip' => '',
            'description' => '',
        ],
        'register_pub_theme' => [
            'label' => 'Register theme views and translations',
            'placeholder' => '',
            'helper_text' => 'Off: the site uses the module views. On: the chosen theme overrides the views and loads its translations.',
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
