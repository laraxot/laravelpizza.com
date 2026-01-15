<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'OAuth授权码',
        'group' => '',
        'icon' => 'heroicon-o-key',
        'sort' => 32,
    ],
    'label' => 'OAuth授权码',
    'plural_label' => 'OAuth授权码',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'user_id' => [
            'label' => '用户',
        ],
        'client_id' => [
            'label' => '客户端',
        ],
        'name' => [
            'label' => '名称',
        ],
        'scopes' => [
            'label' => '范围',
        ],
        'revoked' => [
            'label' => '已撤销',
        ],
        'expires_at' => [
            'label' => '过期时间',
        ],
    ],
    'actions' => [
        'revoke' => [
            'label' => '撤销',
        ],
        'view_scopes' => [
            'label' => '查看范围',
        ],
    ],
];
