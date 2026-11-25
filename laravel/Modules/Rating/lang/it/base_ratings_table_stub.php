<?php

declare(strict_types=1);

return [
    'fields' => [
        'id' => ['label' => 'id'],
        'title' => ['label' => 'title'],
        'slug' => ['label' => 'slug'],
        'rule' => ['label' => 'rule'],
        'is_disabled' => ['label' => 'is_disabled'],
        'is_readonly' => ['label' => 'is_readonly'],
        'order_column' => ['label' => 'order_column'],
        'created_at' => ['label' => 'created_at'],
        'updated_at' => ['label' => 'updated_at'],
    ],
    'actions' => [
        'edit' => ['label' => 'edit', 'icon' => 'edit', 'tooltip' => 'edit'],
        'delete' => ['label' => 'delete', 'icon' => 'delete', 'tooltip' => 'delete'],
    ],
];
