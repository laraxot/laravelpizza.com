<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'OAuth刷新令牌',
        'group' => '',
        'icon' => 'heroicon-o-arrow-path',
        'sort' => 34,
    ],
    'label' => 'OAuth刷新令牌',
    'plural_label' => 'OAuth刷新令牌',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'access_token_id' => [
            'label' => '访问令牌',
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
    ],
];
