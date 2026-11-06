<?php

declare(strict_types=1);

return [
    'fields' => [
        'id' => ['label' => 'id'],
        'user_id' => ['label' => 'user_id'],
        'name' => ['label' => 'name'],
        'provider' => ['label' => 'provider'],
        'redirect' => ['label' => 'redirect'],
        'personal_access_client' => ['label' => 'personal_access_client'],
        'password_client' => ['label' => 'password_client'],
        'revoked' => ['label' => 'revoked'],
        'created_at' => ['label' => 'created_at'],
        'updated_at' => ['label' => 'updated_at'],
        'grant_types' => ['label' => 'grant_types'],
        'redirect_uris' => ['label' => 'redirect_uris'],
        'owner_id' => ['label' => 'owner_id'],
        'owner_type' => ['label' => 'owner_type'],
    ],
    'actions' => [
        'create' => ['label' => 'create', 'icon' => 'create', 'tooltip' => 'create'],
        'layout' => ['label' => 'layout', 'icon' => 'layout', 'tooltip' => 'layout'],
        'delete' => ['label' => 'delete', 'icon' => 'delete', 'tooltip' => 'delete'],
        'view' => ['label' => 'view', 'icon' => 'view', 'tooltip' => 'view'],
        'edit' => ['label' => 'edit', 'icon' => 'edit', 'tooltip' => 'edit'],
    ],
];
