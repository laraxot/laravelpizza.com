<?php

declare(strict_types=1);

return [
    'actions' => [
        'create' => [
            'icon' => 'create',
        ],
    ],
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'uuid' => [
            'label' => 'UUID',
        ],
        'tokenable_type' => [
            'label' => 'Tipo di proprietario',
        ],
        'tokenable_id' => [
            'label' => 'Proprietario',
        ],
        'name' => [
            'label' => 'Nome',
        ],
        'token' => [
            'label' => 'Token',
        ],
        'abilities' => [
            'label' => 'Permessi',
        ],
        'last_used_at' => [
            'label' => 'Ultimo uso',
        ],
        'expires_at' => [
            'label' => 'Scade il',
        ],
        'created_at' => [
            'label' => 'Creato il',
        ],
        'updated_at' => [
            'label' => 'Modificato il',
        ],
        'deleted_at' => [
            'label' => 'Eliminato il',
        ],
        'updated_by' => [
            'label' => 'Modificato da',
        ],
        'created_by' => [
            'label' => 'Creato da',
        ],
        'deleted_by' => [
            'label' => 'Eliminato da',
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
        'scopes' => [
            'label' => 'Ambiti',
        ],
    ],
];
