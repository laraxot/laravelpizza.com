<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Passport / API',
        'plural_label' => 'Passport / API',
        'group' => 'Sistema',
        'icon' => 'heroicon-o-key',
        'sort' => 95,
    ],
    'label' => 'Passport / API',
    'plural_label' => 'Passport / API',
    'fields' => [
        'client_id' => [
            'label' => 'Client ID',
            'placeholder' => 'Inserisci il client ID',
            'help' => 'Identificativo del client OAuth',
        ],
        'client_secret' => [
            'label' => 'Client Secret',
            'placeholder' => 'Inserisci il client secret',
            'help' => 'Secret per l\'autenticazione OAuth',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Client',
            'tooltip' => 'Crea un nuovo client OAuth',
        ],
        'revoke' => [
            'label' => 'Revoca',
            'tooltip' => 'Revoca l\'accesso',
        ],
    ],
    'messages' => [
        'client_created' => 'Client creato con successo',
        'client_revoked' => 'Client revocato con successo',
    ],
];
