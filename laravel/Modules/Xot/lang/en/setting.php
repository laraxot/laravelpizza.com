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
        'main_module' => [
            'label' => 'Main module',
            'placeholder' => 'Choose a module',
            'helper_text' => 'Its panel is the default one. Only enabled modules that have a panel.',
            'tooltip' => '',
            'description' => '',
        ],
        'primary_lang' => [
            'label' => 'Primary language',
            'placeholder' => 'Choose a language',
            'helper_text' => 'Content language used when the translation for the current language is missing.',
            'tooltip' => '',
            'description' => '',
        ],
        'force_ssl' => [
            'label' => 'Force https',
            'placeholder' => '',
            'helper_text' => 'Generate URLs with https. Ignored locally (localhost, 127.0.0.1).',
            'tooltip' => '',
            'description' => '',
        ],
        'disable_database_notifications' => [
            'label' => 'Hide panel notifications',
            'placeholder' => '',
            'helper_text' => 'On: no bell in the panels. Off: the bell reads notifications from the database.',
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
