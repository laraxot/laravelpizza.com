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
        'team_id' => [
            'label' => '团队',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'role' => [
            'label' => '角色',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'invited_by_id' => [
            'label' => '邀请人',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'accepted_at' => [
            'label' => '接受时间',
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
