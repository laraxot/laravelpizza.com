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
        'title' => [
            'label' => 'Site name',
            'placeholder' => 'The name shown in the panels',
            'helper_text' => 'Brand name: admin panel top bar, title and site name in the front office, structured data.',
            'tooltip' => '',
            'description' => '',
        ],
        'logo_height' => [
            'label' => 'Logo height',
            'placeholder' => '2em',
            'helper_text' => 'Logo height in the admin panels: a number with px, em or rem (e.g. 2em, 32px).',
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
