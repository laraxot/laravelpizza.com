<?php

declare(strict_types=1);

return [
    'fields' => [
        'id' => ['label' => 'id'],
        'name' => ['label' => 'name'],
        'created_at' => ['label' => 'created_at'],
        'user' => [
            'name' => ['label' => 'user.name'],
        ],
        'first_name' => ['label' => 'first_name'],
        'last_name' => ['label' => 'last_name'],
        'email' => ['label' => 'email'],
        'is_active' => ['label' => 'is_active'],
        'photo' => ['label' => 'photo'],
    ],
    'actions' => [
        'create' => ['label' => 'create', 'icon' => 'create', 'tooltip' => 'create'],
        'layout' => ['label' => 'layout', 'icon' => 'layout', 'tooltip' => 'layout'],
        'delete' => ['label' => 'delete', 'icon' => 'delete', 'tooltip' => 'delete'],
    ],
];
