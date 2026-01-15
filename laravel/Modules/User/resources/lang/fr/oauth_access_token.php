<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Jetons d\'Accès OAuth',
        'group' => '',
        'icon' => 'heroicon-o-key',
        'sort' => 33,
    ],
    'label' => 'Jeton d\'Accès OAuth',
    'plural_label' => 'Jetons d\'Accès OAuth',
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
            'label' => 'Portées',
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
