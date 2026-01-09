<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => '租户用户',
        'group' => '租户',
        'icon' => 'heroicon-o-user-circle',
        'sort' => 39,
    ],
    'label' => '租户用户',
    'plural_label' => '租户用户',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'user_id' => [
            'label' => '用户',
        ],
        'tenant_id' => [
            'label' => '租户',
        ],
        'role' => [
            'label' => '角色',
        ],
        'created_at' => [
            'label' => '创建时间',
        ],
        'updated_at' => [
            'label' => '更新时间',
        ],
    ],
    'actions' => [
        'change_role' => [
            'label' => '更改角色',
        ],
        'remove_user' => [
            'label' => '移除用户',
        ],
    ],
];
