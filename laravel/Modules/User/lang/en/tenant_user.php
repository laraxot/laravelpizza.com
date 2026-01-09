<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Tenant User',
        'group' => 'Tenant',
        'icon' => 'heroicon-o-user-circle',
        'sort' => 39,
    ],
    'label' => 'Tenant User',
    'plural_label' => 'Tenant Users',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'user_id' => [
            'label' => 'User',
        ],
        'tenant_id' => [
            'label' => 'Tenant',
        ],
        'role' => [
            'label' => 'Role',
        ],
        'created_at' => [
            'label' => 'Created At',
        ],
        'updated_at' => [
            'label' => 'Updated At',
        ],
    ],
    'actions' => [
        'change_role' => [
            'label' => 'Change Role',
        ],
        'remove_user' => [
            'label' => 'Remove User',
        ],
    ],
];