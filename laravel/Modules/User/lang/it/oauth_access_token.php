<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Token di accesso OAuth',
        'group' => '',
        'icon' => 'heroicon-o-key',
        'sort' => 33,
    ],
    'label' => 'Token di accesso OAuth',
    'plural_label' => 'Token di accesso OAuth',
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
        'user' => [
            'name' => [
                'label' => 'user.name',
            ],
        ],
        'client' => [
            'name' => [
                'label' => 'client.name',
            ],
        ],
        'created_at' => [
            'label' => 'created_at',
        ],
        'expired' => [
            'label' => 'expired',
        ],
        'valid' => [
            'label' => 'valid',
        ],
    ],
    'actions' => [
        'revoke' => [
            'label' => 'Revoca',
        ],
        'refresh' => [
            'label' => 'Aggiorna',
        ],
        'revoke_all_for_user' => [
            'label' => 'Revoca tutti per utente',
            'success' => ':count token revocati con successo.',
        ],
        'logout' => [
            'tooltip' => 'logout',
            'icon' => 'logout',
            'label' => 'logout',
        ],
        'delete' => [
            'label' => 'delete',
            'icon' => 'delete',
            'tooltip' => 'delete',
        ],
        'create' => [
            'label' => 'create',
            'icon' => 'create',
            'tooltip' => 'create',
        ],
        'layout' => [
            'label' => 'layout',
            'icon' => 'layout',
            'tooltip' => 'layout',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
            'icon' => 'applyFilters',
            'tooltip' => 'applyFilters',
        ],
        'openFilters' => [
            'label' => 'openFilters',
            'icon' => 'openFilters',
            'tooltip' => 'openFilters',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
            'icon' => 'resetFilters',
            'tooltip' => 'resetFilters',
        ],
        'applyTableColumnManager' => [
            'label' => 'applyTableColumnManager',
            'icon' => 'applyTableColumnManager',
            'tooltip' => 'applyTableColumnManager',
        ],
        'openColumnManager' => [
            'label' => 'openColumnManager',
            'icon' => 'openColumnManager',
            'tooltip' => 'openColumnManager',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
            'icon' => 'reorderRecords',
            'tooltip' => 'reorderRecords',
        ],
        'profile' => [
            'label' => 'profile',
            'icon' => 'profile',
            'tooltip' => 'profile',
        ],
    ],
];
