<?php

declare(strict_types=1);

return [
    'fields' => [
        'id' => ['label' => 'id'],
        'name' => ['label' => 'name'],
        'slug' => ['label' => 'slug'],
        'domain' => ['label' => 'domain'],
        'email_address' => ['label' => 'email_address'],
        'phone' => ['label' => 'phone'],
        'is_active' => ['label' => 'is_active'],
        'created_at' => ['label' => 'created_at'],
        'updated_at' => ['label' => 'updated_at'],
        'email' => ['label' => 'email'],
        'mobile_phone' => ['label' => 'mobile_phone'],
        'team_id' => ['label' => 'team_id'],
        'user_id' => ['label' => 'user_id'],
    ],
    'actions' => [
        'create' => ['label' => 'create', 'icon' => 'create', 'tooltip' => 'create'],
        'layout' => ['label' => 'layout', 'icon' => 'layout', 'tooltip' => 'layout'],
        'delete' => ['label' => 'delete', 'icon' => 'delete', 'tooltip' => 'delete'],
        'edit' => ['tooltip' => 'edit', 'icon' => 'edit', 'label' => 'edit'],
        'view' => ['label' => 'view', 'icon' => 'view', 'tooltip' => 'view'],
    ],
];
