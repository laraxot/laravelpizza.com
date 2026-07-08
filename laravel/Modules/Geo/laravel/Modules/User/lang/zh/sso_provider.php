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
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'name' => [
            'label' => '名称',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'provider' => [
            'label' => '提供商',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'client_id' => [
            'label' => '客户端ID',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'client_secret' => [
            'label' => '客户端密钥',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'redirect' => [
            'label' => '重定向',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'active' => [
            'label' => '激活',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'created_at' => [
            'label' => '创建时间',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'updated_at' => [
            'label' => '更新时间',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
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
