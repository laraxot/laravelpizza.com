<?php

return [
    'navigation' => [
        'label' => 'Settings',
        'group' => 'Configuration',
        'icon' => 'heroicon-o-cog-6-tooth',
        'sort' => '99',
    ],
    'title' => 'Settings',
    'fields' => [
        'default_locale' => [
            'label' => 'Editor opening language',
            'placeholder' => 'Same as the application',
            'helper_text' => 'Language the translation editor opens with. If it is not among the chosen languages, or empty, the application language (app.locale) is used.',
            'tooltip' => '',
            'description' => '',
        ],
        'supported_locales' => [
            'label' => 'Translation editor languages',
            'placeholder' => '',
            'helper_text' => 'The languages in which translation files are edited. It does not change the site languages, which depend on laravellocalization.',
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
