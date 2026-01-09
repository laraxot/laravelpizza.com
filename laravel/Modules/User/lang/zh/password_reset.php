<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => '密码重置',
        'group' => '安全',
        'icon' => 'heroicon-o-key',
        'sort' => 42,
    ],
    'label' => '密码重置',
    'plural_label' => '密码重置',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'email' => [
            'label' => '邮箱',
        ],
        'token' => [
            'label' => '令牌',
        ],
        'created_at' => [
            'label' => '创建时间',
        ],
    ],
    'actions' => [
        'resend_email' => [
            'label' => '重新发送邮件',
        ],
        'view_request' => [
            'label' => '查看请求',
        ],
    ],
];
