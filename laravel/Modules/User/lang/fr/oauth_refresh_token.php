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
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'access_token_id' => [
            'label' => 'Jeton d\'Accès',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'revoked' => [
            'label' => 'Révoqué',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'expires_at' => [
            'label' => 'Expire À',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'revoke' => [
            'label' => 'Révoquer',
        ],
    ],
];
