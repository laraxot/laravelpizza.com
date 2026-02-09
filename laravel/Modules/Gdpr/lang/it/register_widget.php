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
        ],
        'last_name' => [
            'label' => 'last_name',
            'placeholder' => 'last_name',
            'helper_text' => 'last_name',
            'description' => 'last_name',
        ],
        'email' => [
            'label' => 'email',
            'placeholder' => 'email',
            'helper_text' => 'email',
            'description' => 'email',
        ],
        'third_party_consent' => [
            'description' => 'third_party_consent',
        ],
        'already_registered' => [
            'description' => 'already_registered',
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
];
