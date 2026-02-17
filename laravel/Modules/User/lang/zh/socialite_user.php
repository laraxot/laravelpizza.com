<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Socialite用户',
        'group' => '认证',
        'icon' => 'heroicon-o-user-group',
        'sort' => 40,
    ],
    'label' => 'Socialite用户',
    'plural_label' => 'Socialite用户',
    'fields' => [
        'id' => [
            'label' => 'ID',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'user_id' => [
            'label' => '用户',
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
        'provider_id' => [
            'label' => '提供商ID',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'name' => [
            'label' => '姓名',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'email' => [
            'label' => '邮箱',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'avatar' => [
            'label' => '头像',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'token' => [
            'label' => '令牌',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'refresh_token' => [
            'label' => '刷新令牌',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'expires_at' => [
            'label' => '过期时间',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'link_provider' => [
            'label' => '关联提供商',
        ],
        'unlink_provider' => [
            'label' => '取消关联提供商',
        ],
    ],
];
