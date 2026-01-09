<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Code d\'authentification OAuth',
        'group' => 'OAuth',
        'icon' => 'heroicon-o-key',
        'sort' => 32,
    ],
    'label' => 'Code d\'authentification OAuth',
    'plural_label' => 'Codes d\'authentification OAuth',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'user_id' => [
            'label' => 'Utilisateur',
        ],
        'client_id' => [
            'label' => 'Client',
        ],
        'name' => [
            'label' => 'Nom',
        ],
        'scopes' => [
            'label' => 'Périmètres',
        ],
        'revoked' => [
            'label' => 'Révoqué',
        ],
        'expires_at' => [
            'label' => 'Expire le',
        ],
    ],
    'actions' => [
        'revoke' => [
            'label' => 'Révoquer',
        ],
        'view_scopes' => [
            'label' => 'Voir les périmètres',
        ],
    ],
];
