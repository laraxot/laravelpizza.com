<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Utente del tenant',
        'group' => 'Tenant',
        'icon' => 'heroicon-o-user-circle',
        'sort' => 39,
    ],
    'label' => 'Utente del tenant',
    'plural_label' => 'Utenti del tenant',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'user_id' => [
            'label' => 'Utente',
        ],
        'tenant_id' => [
            'label' => 'Tenant',
        ],
        'role' => [
            'label' => 'Ruolo',
        ],
        'created_at' => [
            'label' => 'Creato il',
        ],
        'updated_at' => [
            'label' => 'Aggiornato il',
        ],
    ],
    'actions' => [
        'change_role' => [
            'label' => 'Cambia ruolo',
        ],
        'remove_user' => [
            'label' => 'Rimuovi utente',
        ],
    ],
];
