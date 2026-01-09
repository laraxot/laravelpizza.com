<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Jeton d\'actualisation OAuth',
        'group' => 'OAuth',
        'icon' => 'heroicon-o-arrow-path',
        'sort' => 34,
    ],
    'label' => 'Jeton d\'actualisation OAuth',
    'plural_label' => 'Jetons d\'actualisation OAuth',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'access_token_id' => [
            'label' => 'Jeton d\'accès',
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
    ],
];
