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
        'consent_lifetime' => [
            'label' => 'Cookie choice validity (days)',
            'placeholder' => '180',
            'helper_text' => 'The banner is not shown again before this period. The Italian regulator does not allow less than 6 months: minimum 180.',
            'tooltip' => '',
            'description' => '',
        ],
        'policy_path' => [
            'label' => 'Cookie policy page',
            'placeholder' => '/cookie-policy',
            'helper_text' => 'Path without the language (e.g. /cookie-policy): the site adds the language prefix.',
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
