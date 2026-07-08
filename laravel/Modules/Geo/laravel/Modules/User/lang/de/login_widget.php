<?php

declare(strict_types=1);

return [
    'fields' => [
        'email' => [
            'label' => 'E-Mail',
            'placeholder' => 'Geben Sie Ihre E-Mail ein',
            'help' => 'Geben Sie die E-Mail-Adresse ein, mit der Sie sich registriert haben',
            'description' => 'E-Mail-Adresse für die Anmeldung',
            'tooltip' => '',
            'helper_text' => '',
        ],
        'password' => [
            'label' => 'Passwort',
            'placeholder' => 'Geben Sie Ihr Passwort ein',
            'help' => 'Geben Sie Ihr Kontopasswort ein',
            'description' => 'Passwort für die Anmeldung',
            'tooltip' => '',
            'helper_text' => '',
        ],
        'remember' => [
            'label' => 'Angemeldet bleiben',
            'placeholder' => 'Sitzung aktiv halten',
            'help' => 'Wählen Sie aus, um Ihre Sitzung 30 Tage lang aktiv zu halten',
            'description' => 'Option zum Merken der Anmeldung',
            'tooltip' => '',
            'helper_text' => '',
        ],
    ],
    'actions' => [
        'login' => [
            'label' => 'Anmelden',
            'tooltip' => 'Klicken Sie, um auf Ihr Konto zuzugreifen',
        ],
        'hidePassword' => [
            'tooltip' => 'hidePassword',
            'label' => 'hidePassword',
            'icon' => 'hidePassword',
        ],
        'showPassword' => [
            'label' => 'showPassword',
            'icon' => 'showPassword',
            'tooltip' => 'showPassword',
        ],
    ],
    'messages' => [
        'login_success' => 'Anmeldung erfolgreich',
        'login_error' => 'Fehler bei der Anmeldung',
        'validation_error' => 'Validierungsfehler',
        'credentials_incorrect' => 'Falsche Anmeldedaten',
    ],
    'ui' => [
        'login_button' => 'Anmelden',
        'forgot_password' => 'Passwort vergessen?',
        'errors_title' => 'Es sind einige Fehler aufgetreten',
    ],
    'navigation' => [
        'label' => 'Missing Navigation Label',
        'plural_label' => 'Missing Navigation Plural Label',
        'group' => 'Missing Group',
        'icon' => 'heroicon-o-puzzle-piece',
        'sort' => 100,
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
];
