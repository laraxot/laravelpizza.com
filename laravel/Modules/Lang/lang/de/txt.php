<?php

declare(strict_types=1);

return [
    'fields' => [
        'email' => [
            'label' => 'E-Mail',
            'placeholder' => 'Geben Sie Ihre E-Mail ein',
            'tooltip' => 'Verwenden Sie eine gültige E-Mail-Adresse',
            'icon' => 'heroicon-o-envelope',
            'helper_text' => '',
        ],
        'password' => [
            'label' => 'Passwort',
            'placeholder' => 'Geben Sie Ihr Passwort ein',
            'tooltip' => 'Das Passwort muss mindestens 8 Zeichen enthalten',
            'icon' => 'heroicon-o-lock-closed',
            'helper_text' => '',
        ],
        'remember' => [
            'label' => 'Angemeldet bleiben',
            'tooltip' => 'Halten Sie mich auf diesem Gerät angemeldet',
            'helper_text' => '',
        ],
    ],
    'actions' => [
        'authenticate' => [
            'label' => 'Authentifizieren',
            'tooltip' => 'Im System anmelden',
            'icon' => 'ui-login',
            'color' => 'primary',
        ],
        'login' => [
            'label' => 'Anmelden',
            'tooltip' => 'Mit Ihren Anmeldedaten anmelden',
            'icon' => 'heroicon-o-key',
            'color' => 'success',
        ],
    ],
    'navigation' => [
        'label' => 'Missing Navigation Label',
        'plural_label' => 'Missing Navigation Plural Label',
        'group' => 'Missing Group',
        'icon' => 'heroicon-o-puzzle-piece',
        'sort' => '100',
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
];
