<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'OAuth-Zugriffstoken',
        'group' => '',
        'icon' => 'heroicon-o-key',
        'sort' => 33,
    ],
    'label' => 'OAuth-Zugriffstoken',
    'plural_label' => 'OAuth-Zugriffstoken',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'user_id' => [
            'label' => 'Benutzer',
        ],
        'client_id' => [
            'label' => 'Client',
        ],
        'name' => [
            'label' => 'Name',
        ],
        'scopes' => [
            'label' => 'Bereiche',
        ],
        'revoked' => [
            'label' => 'Widerrufen',
        ],
        'expires_at' => [
            'label' => 'Läuft Ab Am',
        ],
    ],
    'actions' => [
        'revoke' => [
            'label' => 'Widerrufen',
        ],
        'refresh' => [
            'label' => 'Aktualisieren',
        ],
    ],
];
