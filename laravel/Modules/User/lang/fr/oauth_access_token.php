<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Jeton d\'accès OAuth',
        'group' => 'OAuth',
        'icon' => 'heroicon-o-key',
        'sort' => 33,
    ],
    'label' => 'Jeton d\'accès OAuth',
    'plural_label' => 'Jetons d\'accès OAuth',
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
        'refresh' => [
            'label' => 'Actualiser',
        ],
    ],
];
