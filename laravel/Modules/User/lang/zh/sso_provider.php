<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'SSO提供商',
        'group' => '认证',
        'icon' => 'heroicon-o-shield-check',
        'sort' => 41,
    ],
    'label' => 'SSO提供商',
    'plural_label' => 'SSO提供商',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'name' => [
            'label' => '名称',
        ],
        'provider' => [
            'label' => '提供商',
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
        'active' => [
            'label' => '激活',
        ],
        'created_at' => [
            'label' => '创建时间',
        ],
        'updated_at' => [
            'label' => '更新时间',
        ],
    ],
    'actions' => [
        'activate' => [
            'label' => '激活',
        ],
        'deactivate' => [
            'label' => '停用',
        ],
        'test_connection' => [
            'label' => '测试连接',
        ],
    ],
];
