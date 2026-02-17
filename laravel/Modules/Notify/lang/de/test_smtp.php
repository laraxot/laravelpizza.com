<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'SMTP-Test',
        'group' => 'Benachrichtigungen',
        'icon' => 'heroicon-o-envelope-open',
        'sort' => 47,
    ],
    'label' => 'SMTP-Test',
    'plural_label' => 'SMTP-Tests',
    'fields' => [
        'id' => [
            'label' => 'ID',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'name' => [
            'label' => 'Name',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'host' => [
            'label' => 'Host',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'port' => [
            'label' => 'Port',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'username' => [
            'label' => 'Benutzername',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'password' => [
            'label' => 'Passwort',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'encryption' => [
            'label' => 'Verschlüsselung',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'from_address' => [
            'label' => 'Absenderadresse',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'from_name' => [
            'label' => 'Absendername',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'status' => [
            'label' => 'Status',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'last_tested_at' => [
            'label' => 'Zuletzt Getestet Am',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'created_at' => [
            'label' => 'Erstellt Am',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'body_html' => [
            'description' => 'HTML-Körper',
            'helper_text' => 'HTML-Inhalt der E-Mail',
            'label' => '',
            'tooltip' => '',
        ],
    ],
    'actions' => [
        'logout' => [
            'tooltip' => 'Abmelden',
            'icon' => 'logout',
            'label' => 'Abmelden',
        ],
        'emailFormActions' => [
            'tooltip' => 'E-Mail-Formularaktionen',
            'icon' => 'emailFormActions',
            'label' => 'E-Mail-Formularaktionen',
        ],
        'profile' => [
            'tooltip' => 'Profil',
            'icon' => 'profile',
        ],
        'send_test_email' => [
            'label' => 'Test-E-Mail Senden',
        ],
        'test_connection' => [
            'label' => 'Verbindung Testen',
        ],
    ],
];
