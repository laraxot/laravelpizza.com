<?php

declare(strict_types=1);

return [
    'fields' => [
        'id' => ['label' => 'id'],
        'uuid' => ['label' => 'uuid'],
        'name' => ['label' => 'name'],
        'slug' => ['label' => 'slug'],
        'provider' => ['label' => 'provider'],
        'is_active' => ['label' => 'is_active'],
        'created_at' => ['label' => 'created_at'],
        'updated_at' => ['label' => 'updated_at'],
        'updated_by' => ['label' => 'updated_by'],
        'created_by' => ['label' => 'created_by'],
        'display_name' => ['label' => 'display_name'],
        'type' => ['label' => 'type'],
        'entity_id' => ['label' => 'entity_id'],
        'redirect_url' => ['label' => 'redirect_url'],
    ],
    'actions' => [
        'create' => ['label' => 'create', 'icon' => 'create', 'tooltip' => 'create'],
        'layout' => ['label' => 'layout', 'icon' => 'layout', 'tooltip' => 'layout'],
        'delete' => ['label' => 'delete', 'icon' => 'delete', 'tooltip' => 'delete'],
        'view' => ['label' => 'view', 'icon' => 'view', 'tooltip' => 'view'],
        'edit' => ['label' => 'edit', 'icon' => 'edit', 'tooltip' => 'edit'],
    ],
];
