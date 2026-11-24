<?php

declare(strict_types=1);

return [
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'name',
            'helper_text' => 'name',
            'description' => 'name',
        ],
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
        'user_code' => [
            'label' => 'user_code',
            'placeholder' => 'user_code',
            'helper_text' => 'user_code',
            'description' => 'user_code',
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
        'user_approved_at' => [
            'label' => 'Approvato il',
            'placeholder' => 'user_approved_at',
            'helper_text' => 'user_approved_at',
            'description' => 'user_approved_at',
        ],
        'last_polled_at' => [
            'label' => 'last_polled_at',
            'placeholder' => 'last_polled_at',
            'helper_text' => 'last_polled_at',
            'description' => 'last_polled_at',
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
        'Codice Dispositivo OAuth' => [
            'label' => 'Codice Dispositivo OAuth',
            'heading' => 'Codice Dispositivo OAuth',
        ],
    ],
];
