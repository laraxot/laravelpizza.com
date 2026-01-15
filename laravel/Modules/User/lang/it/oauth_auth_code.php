<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'OAuth Authorization Codes',
        'group' => '',
        'icon' => 'heroicon-o-code-bracket',
        'sort' => 31,
    ],
    'label' => 'Codice di autorizzazione OAuth',
    'plural_label' => 'Codici di autorizzazione OAuth',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'user_id' => [
            'label' => 'Utente',
        ],
        'client_id' => [
            'label' => 'Client',
        ],
        'scopes' => [
            'label' => 'Ambiti',
        ],
        'revoked' => [
            'label' => 'Revocato',
        ],
        'expires_at' => [
            'label' => 'Scade il',
        ],
    ],
    'actions' => [
        'revoke' => [
            'label' => 'Revoca',
            'success' => 'Codice di autorizzazione revocato con successo',
        ],
    ],
];
