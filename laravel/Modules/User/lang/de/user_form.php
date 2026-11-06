<?php

declare(strict_types=1);

return [
    'fields' => [
        'first_name' => [
            'label' => 'Vorname',
            'placeholder' => 'Max',
            'helper_text' => 'Ihr Vorname',
            'description' => 'Vorname',
        ],
        'last_name' => [
            'label' => 'Nachname',
            'placeholder' => 'Mustermann',
            'helper_text' => 'Ihr Nachname',
            'description' => 'Nachname',
        ],
        'email' => [
            'label' => 'E-Mail-Adresse',
            'placeholder' => 'max.mustermann@beispiel.de',
            'helper_text' => 'Verwenden Sie die E-Mail-Adresse, mit der Sie sich anmelden.',
            'description' => 'E-Mail',
        ],
        'password' => [
            'label' => 'Passwort',
            'placeholder' => 'Sicheres Passwort eingeben',
            'helper_text' => 'Mindestens 12 Zeichen, ein Großbuchstabe, ein Kleinbuchstabe, eine Zahl und ein Sonderzeichen.',
            'description' => 'Zugangspasswort',
        ],
        'password_confirmation' => [
            'label' => 'Passwort bestätigen',
            'placeholder' => 'Passwort wiederholen',
            'helper_text' => 'Muss mit dem oben eingegebenen Passwort übereinstimmen.',
            'description' => 'Passwort bestätigen',
        ],
        'remember' => [
            'label' => 'Angemeldet bleiben',
            'placeholder' => '',
            'helper_text' => 'Verlängerte Sitzung auf einem vertrauenswürdigen Gerät',
            'description' => 'Auf diesem Gerät angemeldet bleiben',
        ],
    ],
    'actions' => [
        'showPassword' => [
            'label' => 'Passwort anzeigen',
            'icon' => 'heroicon-o-eye',
            'tooltip' => 'Passwort anzeigen',
        ],
        'hidePassword' => [
            'label' => 'Passwort verbergen',
            'icon' => 'heroicon-o-eye-slash',
            'tooltip' => 'Passwort verbergen',
        ],
    ],
];
