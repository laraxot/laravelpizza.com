<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Codice di autorizzazione OAuth',
        'group' => 'OAuth',
        'icon' => 'heroicon-o-key',
        'sort' => 32,
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
        'name' => [
            'label' => 'Nome',
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
        ],
        'view_scopes' => [
            'label' => 'Visualizza ambiti',
        ],
    ],
];
