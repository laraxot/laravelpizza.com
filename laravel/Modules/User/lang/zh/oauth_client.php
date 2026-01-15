<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'OAuth客户端',
        'group' => '',
        'icon' => 'heroicon-o-key',
        'sort' => 46,
    ],
    'label' => 'OAuth客户端',
    'plural_label' => 'OAuth客户端',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'user_id' => [
            'label' => '用户',
        ],
        'name' => [
            'label' => '名称',
        ],
        'secret' => [
            'label' => '密钥',
        ],
        'provider' => [
            'label' => '提供商',
        ],
        'redirect' => [
            'label' => '重定向',
        ],
        'personal_access_client' => [
            'label' => '个人访问客户端',
        ],
        'password_client' => [
            'label' => '密码客户端',
        ],
        'revoked' => [
            'label' => '已撤销',
        ],
        'created_at' => [
            'label' => '创建时间',
        ],
        'updated_at' => [
            'label' => '更新时间',
        ],
    ],
    'actions' => [
        'create_client' => [
            'label' => '创建客户端',
        ],
        'revoke' => [
            'label' => '撤销',
        ],
    ],
];
