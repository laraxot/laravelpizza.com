<?php

declare(strict_types=1);

return [
    'fields' => [
        'id' => ['label' => 'id'],
        'type' => ['label' => 'type'],
        'status' => ['label' => 'status'],
        'read_at' => ['label' => 'read_at'],
        'sent_at' => ['label' => 'sent_at'],
        'created_at' => ['label' => 'created_at'],
        'updated_at' => ['label' => 'updated_at'],
        'is_read' => ['label' => 'is_read'],
        'is_unread' => ['label' => 'is_unread'],
        'notifiable_type' => ['label' => 'notifiable_type'],
        'notifiable_id' => ['label' => 'notifiable_id'],
    ],
    'actions' => [
        'create' => ['label' => 'create', 'icon' => 'create', 'tooltip' => 'create'],
        'layout' => ['label' => 'layout', 'icon' => 'layout', 'tooltip' => 'layout'],
        'delete' => ['label' => 'delete', 'icon' => 'delete', 'tooltip' => 'delete'],
    ],
];
