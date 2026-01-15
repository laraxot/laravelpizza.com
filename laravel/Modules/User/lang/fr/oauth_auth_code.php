<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Code d\'Autorisation OAuth',
        'group' => '',
        'icon' => 'heroicon-o-key',
        'sort' => 32,
    ],
    'label' => 'Code d\'Autorisation OAuth',
    'plural_label' => 'Codes d\'Autorisation OAuth',
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
            'label' => 'Expire À',
        ],
    ],
    'actions' => [
        'revoke' => [
            'label' => 'Révoquer',
        ],
        'view_scopes' => [
            'label' => 'Voir les Portées',
        ],
    ],
];
