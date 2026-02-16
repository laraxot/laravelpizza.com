<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Passwort-Zurücksetzung',
        'group' => 'Sicherheit',
        'icon' => 'heroicon-o-key',
        'sort' => 42,
    ],
    'label' => 'Passwort-Zurücksetzung',
    'plural_label' => 'Passwort-Zurücksetzungen',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'email' => [
            'label' => 'E-Mail',
        ],
        'token' => [
            'label' => 'Token',
        ],
        'created_at' => [
            'label' => 'Erstellt Am',
        ],
    ],
    'actions' => [
        'resend_email' => [
            'label' => 'E-Mail Erneut Senden',
        ],
        'view_request' => [
            'label' => 'Anfrage Anzeigen',
        ],
    ],
];
