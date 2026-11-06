<?php

declare(strict_types=1);

return [
    'fields' => [
        'id' => ['label' => 'id'],
        'uuid' => ['label' => 'uuid'],
        'role' => ['label' => 'role'],
        'team_id' => ['label' => 'team_id'],
        'user_id' => ['label' => 'user_id'],
        'customer_id' => ['label' => 'customer_id'],
        'joined_at' => ['label' => 'joined_at'],
        'created_at' => ['label' => 'created_at'],
        'updated_at' => ['label' => 'updated_at'],
    ],
    'actions' => [
        'create' => ['label' => 'create', 'icon' => 'create', 'tooltip' => 'create'],
        'layout' => ['label' => 'layout', 'icon' => 'layout', 'tooltip' => 'layout'],
        'delete' => ['label' => 'delete', 'icon' => 'delete', 'tooltip' => 'delete'],
        'edit' => ['tooltip' => 'edit', 'icon' => 'edit', 'label' => 'edit'],
        'view' => ['label' => 'view', 'icon' => 'view', 'tooltip' => 'view'],
    ],
];
