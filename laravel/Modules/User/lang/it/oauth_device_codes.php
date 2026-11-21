<?php

declare(strict_types=1);

return [
    'actions' => [
        'create' => [
            'icon' => 'create',
        ],
        'view' => [
            'icon' => 'view',
        ],
        'edit' => [
            'icon' => 'edit',
        ],
        'delete' => [
            'icon' => 'delete',
        ],
        'layout' => [
            'icon' => 'layout',
        ],
    ],
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'name' => [
            'label' => 'Nome',
        ],
        'created_at' => [
            'label' => 'Creato il',
        ],
        'user_id' => [
            'label' => 'Utente',
        ],
        'client_id' => [
            'label' => 'Client ID',
        ],
        'revoked' => [
            'label' => 'Revocato',
        ],
        'user_approved_at' => [
            'label' => 'Approvato il',
        ],
        'expires_at' => [
            'label' => 'Scade il',
        ],
        'last_polled_at' => [
            'label' => 'last_polled_at',
        ],
        'scopes' => [
            'label' => 'Ambiti',
        ],
    ],
];
