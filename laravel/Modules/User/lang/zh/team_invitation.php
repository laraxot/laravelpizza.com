<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => '团队邀请',
        'group' => '团队',
        'icon' => 'heroicon-o-user-plus',
        'sort' => 37,
    ],
    'label' => '团队邀请',
    'plural_label' => '团队邀请',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'email' => [
            'label' => '邮箱',
        ],
        'team_id' => [
            'label' => '团队',
        ],
        'role' => [
            'label' => '角色',
        ],
        'invited_by_id' => [
            'label' => '邀请人',
        ],
        'accepted_at' => [
            'label' => '接受时间',
        ],
        'expires_at' => [
            'label' => '过期时间',
        ],
    ],
    'actions' => [
        'resend_invitation' => [
            'label' => '重新发送邀请',
        ],
        'accept_invitation' => [
            'label' => '接受邀请',
        ],
        'cancel_invitation' => [
            'label' => '取消邀请',
        ],
    ],
];
