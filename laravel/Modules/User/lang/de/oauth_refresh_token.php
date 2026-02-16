<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'OAuth-Aktualisierungstoken',
        'group' => '',
        'icon' => 'heroicon-o-arrow-path',
        'sort' => 34,
    ],
    'label' => 'OAuth-Aktualisierungstoken',
    'plural_label' => 'OAuth-Aktualisierungstoken',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'access_token_id' => [
            'label' => 'Zugriffstoken',
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
    ],
];
