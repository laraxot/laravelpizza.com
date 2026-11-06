<?php

declare(strict_types=1);

return [
    'fields' => [
        'id' => ['label' => 'id'],
        'uuid' => ['label' => 'uuid'],
        'user_id' => ['label' => 'user_id'],
        'first_name' => ['label' => 'first_name'],
        'last_name' => ['label' => 'last_name'],
        'email' => ['label' => 'email'],
        'phone' => ['label' => 'phone'],
        'status' => ['label' => 'status'],
        'is_active' => ['label' => 'is_active'],
        'created_at' => ['label' => 'created_at'],
        'updated_at' => ['label' => 'updated_at'],
    ],
    'actions' => [
        'create' => ['label' => 'create', 'icon' => 'create', 'tooltip' => 'create'],
        'layout' => ['label' => 'layout', 'icon' => 'layout', 'tooltip' => 'layout'],
        'delete' => ['label' => 'delete', 'icon' => 'delete', 'tooltip' => 'delete'],
        'view' => ['label' => 'view', 'icon' => 'view', 'tooltip' => 'view'],
        'edit' => ['label' => 'edit', 'icon' => 'edit', 'tooltip' => 'edit'],
    ],
];
