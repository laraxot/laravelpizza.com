<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'OAuth Access Tokens',
        'plural' => 'OAuth Access Tokens',
        'icon' => 'heroicon-o-key',
        'group' => 'OAuth',
        'sort' => 10,
    ],
    'label' => 'OAuth Access Token',
    'plural_label' => 'OAuth Access Tokens',
    'fields' => [
        'id' => ['label' => 'ID'],
        'user.name' => ['label' => 'User'],
        'client.name' => ['label' => 'Client'],
        'name' => ['label' => 'Name'],
        'scopes' => ['label' => 'Scopes'],
        'revoked' => ['label' => 'Revoked'],
        'created_at' => ['label' => 'Created At'],
        'expires_at' => ['label' => 'Expires At'],
        'user_id' => ['label' => 'User ID'],
        'client_id' => ['label' => 'Client ID'],
    ],
];
