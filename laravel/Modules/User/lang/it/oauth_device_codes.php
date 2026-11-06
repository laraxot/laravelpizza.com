<?php

declare(strict_types=1);

return [
    'fields' => [
        'id' => ['label' => 'id'],
        'name' => ['label' => 'name'],
        'created_at' => ['label' => 'created_at'],
        'user_id' => ['label' => 'user_id'],
        'client_id' => ['label' => 'client_id'],
        'revoked' => ['label' => 'revoked'],
        'user_approved_at' => ['label' => 'user_approved_at'],
        'expires_at' => ['label' => 'expires_at'],
        'last_polled_at' => ['label' => 'last_polled_at'],
        'scopes' => ['label' => 'scopes'],
    ],
    'actions' => [
        'create' => ['label' => 'create', 'icon' => 'create', 'tooltip' => 'create'],
        'view' => ['label' => 'view', 'icon' => 'view', 'tooltip' => 'view'],
        'edit' => ['label' => 'edit', 'icon' => 'edit', 'tooltip' => 'edit'],
        'delete' => ['label' => 'delete', 'icon' => 'delete', 'tooltip' => 'delete'],
        'layout' => ['label' => 'layout', 'icon' => 'layout', 'tooltip' => 'layout'],
    ],
];
