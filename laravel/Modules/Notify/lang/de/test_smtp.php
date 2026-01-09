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
        ],
        'name' => [
            'label' => 'Name',
        ],
        'host' => [
            'label' => 'Host',
        ],
        'port' => [
            'label' => 'Port',
        ],
        'username' => [
            'label' => 'Benutzername',
        ],
        'password' => [
            'label' => 'Passwort',
        ],
        'encryption' => [
            'label' => 'Verschlüsselung',
        ],
        'from_address' => [
            'label' => 'Absenderadresse',
        ],
        'from_name' => [
            'label' => 'Absendername',
        ],
        'status' => [
            'label' => 'Status',
        ],
        'last_tested_at' => [
            'label' => 'Zuletzt Getestet Am',
        ],
        'created_at' => [
            'label' => 'Erstellt Am',
        ],
        'body_html' => [
            'description' => 'HTML-Körper',
            'helper_text' => 'HTML-Inhalt der E-Mail',
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
