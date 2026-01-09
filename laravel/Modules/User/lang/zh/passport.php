<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Passport',
        'group' => '安全',
        'icon' => 'heroicon-o-shield-check',
        'sort' => 35,
    ],
    'label' => 'Passport',
    'plural_label' => 'Passport',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'name' => [
            'label' => '名称',
        ],
        'client_id' => [
            'label' => '客户端ID',
        ],
        'client_secret' => [
            'label' => '客户端密钥',
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
