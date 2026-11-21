<?php

declare(strict_types=1);

return [
    'fields' => [
        'user_id' => [
            'label' => 'Utente',
            'placeholder' => 'user_id',
            'helper_text' => 'user_id',
            'description' => 'user_id',
        ],
        'client_id' => [
            'label' => 'Client ID',
            'placeholder' => 'client_id',
            'helper_text' => 'client_id',
            'description' => 'client_id',
        ],
        'scopes' => [
            'label' => 'Ambiti',
            'placeholder' => 'scopes',
            'helper_text' => 'scopes',
            'description' => 'scopes',
        ],
        'revoked' => [
            'label' => 'Revocato',
            'placeholder' => 'revoked',
            'helper_text' => 'revoked',
            'description' => 'revoked',
        ],
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'name',
            'helper_text' => 'name',
            'description' => 'name',
        ],
        'expires_at' => [
            'label' => 'Scade il',
            'placeholder' => 'expires_at',
            'helper_text' => 'expires_at',
            'description' => 'expires_at',
        ],
    ],
    'sections' => [
        'empty' => [
            'label' => '',
            'heading' => 'empty',
        ],
        'Codice Autorizzazione OAuth' => [
            'label' => 'Codice Autorizzazione OAuth',
            'heading' => 'Codice Autorizzazione OAuth',
        ],
    ],
];
