<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'OAuth-Autorisierungscode',
        'group' => '',
        'icon' => 'heroicon-o-key',
        'sort' => 32,
    ],
    'label' => 'OAuth-Autorisierungscode',
    'plural_label' => 'OAuth-Autorisierungscodes',
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
        'view_scopes' => [
            'label' => 'Bereiche Anzeigen',
        ],
    ],
];
