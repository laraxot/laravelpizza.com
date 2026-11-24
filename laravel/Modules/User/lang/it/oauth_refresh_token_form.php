<?php

declare(strict_types=1);

return [
    'fields' => [
        'access_token_id' => [
            'label' => 'access_token_id',
            'placeholder' => 'access_token_id',
            'helper_text' => 'access_token_id',
            'description' => 'access_token_id',
        ],
        'revoked' => [
            'label' => 'Revocato',
            'placeholder' => 'revoked',
            'helper_text' => 'revoked',
            'description' => 'revoked',
        ],
        'expires_at' => [
            'label' => 'Scade il',
            'placeholder' => 'expires_at',
            'helper_text' => 'expires_at',
            'description' => 'expires_at',
        ],
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'name',
            'helper_text' => 'name',
            'description' => 'name',
        ],
    ],
    'sections' => [
        'empty' => [
            'label' => '',
            'heading' => 'empty',
        ],
        'Refresh Token OAuth' => [
            'label' => 'Refresh Token OAuth',
            'heading' => 'Refresh Token OAuth',
        ],
    ],
];
