<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Passport',
        'group' => 'Sicurezza',
        'icon' => 'heroicon-o-shield-check',
        'sort' => 35,
    ],
    'label' => 'Passport',
    'plural_label' => 'Passport',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'name' => [
            'label' => 'Nome',
        ],
        'client_id' => [
            'label' => 'Client ID',
        ],
        'client_secret' => [
            'label' => 'Client Secret',
        ],
        'redirect' => [
            'label' => 'Reindirizza',
        ],
        'personal_access_client' => [
            'label' => 'Client per accesso personale',
        ],
        'password_client' => [
            'label' => 'Client per accesso con password',
        ],
        'revoked' => [
            'label' => 'Revocato',
        ],
    ],
    'actions' => [
        'create_client' => [
            'label' => 'Crea client',
        ],
        'revoke' => [
            'label' => 'Revoca',
        ],
    ],
];