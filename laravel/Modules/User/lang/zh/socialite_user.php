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
        ],
        'user_id' => [
            'label' => '用户',
        ],
        'provider' => [
            'label' => '提供商',
        ],
        'provider_id' => [
            'label' => '提供商ID',
        ],
        'name' => [
            'label' => '姓名',
        ],
        'email' => [
            'label' => '邮箱',
        ],
        'avatar' => [
            'label' => '头像',
        ],
        'token' => [
            'label' => '令牌',
        ],
        'refresh_token' => [
            'label' => '刷新令牌',
        ],
        'expires_at' => [
            'label' => '过期时间',
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
