<?php

declare(strict_types=1);

return [
    'fields' => [
        'email' => [
            'label' => 'E-Mail',
            'placeholder' => 'Geben Sie Ihre E-Mail ein',
            'tooltip' => 'Verwenden Sie eine gültige E-Mail-Adresse',
            'icon' => 'heroicon-o-mail',
            'description' => 'email',
            'helper_text' => '',
        ],
        'password' => [
            'label' => 'Passwort',
            'placeholder' => 'Geben Sie Ihr Passwort ein',
            'tooltip' => 'Das Passwort muss mindestens 8 Zeichen enthalten',
            'icon' => 'heroicon-o-lock-closed',
            'description' => 'password',
            'helper_text' => '',
        ],
        'remember' => [
            'label' => 'Angemeldet bleiben',
            'tooltip' => 'Halten Sie mich auf diesem Gerät angemeldet',
            'description' => 'remember',
            'helper_text' => '',
            'placeholder' => 'remember',
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
        'request' => [
            'label' => 'request',
        ],
    ],
];
