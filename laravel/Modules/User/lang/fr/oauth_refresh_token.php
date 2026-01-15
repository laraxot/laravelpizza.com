<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Jeton de Rafraîchissement OAuth',
        'group' => '',
        'icon' => 'heroicon-o-arrow-path',
        'sort' => 34,
    ],
    'label' => 'Jeton de Rafraîchissement OAuth',
    'plural_label' => 'Jetons de Rafraîchissement OAuth',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'access_token_id' => [
            'label' => 'Jeton d\'Accès',
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
    ],
];
