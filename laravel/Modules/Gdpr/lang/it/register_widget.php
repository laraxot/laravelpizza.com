<?php

declare(strict_types=1);

return [
    'sections' => [
        'Informazioni Personali' => [
            'label' => 'Informazioni Personali',
            'heading' => 'Informazioni Personali',
        ],
        'Consenso Facoltativo' => [
            'heading' => 'Consenso Facoltativo',
        ],
    ],
    'fields' => [
        'first_name' => [
            'label' => 'first_name',
            'placeholder' => 'first_name',
            'helper_text' => 'first_name',
            'description' => 'first_name',
            'tooltip' => '',
        ],
        'last_name' => [
            'label' => 'last_name',
            'placeholder' => 'last_name',
            'helper_text' => 'last_name',
            'description' => 'last_name',
            'tooltip' => '',
        ],
        'email' => [
            'label' => 'email',
            'placeholder' => 'email',
            'helper_text' => 'email',
            'description' => 'email',
            'tooltip' => '',
        ],
        'third_party_consent' => [
            'description' => 'third_party_consent',
            'label' => '',
            'tooltip' => '',
            'helper_text' => '',
        ],
        'already_registered' => [
            'description' => 'already_registered',
            'label' => '',
            'tooltip' => '',
            'helper_text' => '',
        ],
    ],
    'actions' => [
        'hidePassword' => [
            'tooltip' => 'hidePassword',
            'icon' => 'hidePassword',
            'label' => 'hidePassword',
        ],
        'showPassword' => [
            'tooltip' => 'showPassword',
            'icon' => 'showPassword',
            'label' => 'showPassword',
        ],
    ],
    'label' => 'Register Widget',
    'plural_label' => 'Register Widget (Plurale)',
    'navigation' => [
        'name' => 'Register Widget',
        'plural' => 'Register Widget',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Register Widget',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
];
