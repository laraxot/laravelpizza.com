<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => '认证日志',
        'group' => '安全',
        'icon' => 'heroicon-o-lock-closed',
        'sort' => 36,
    ],
    'label' => '认证日志',
    'plural_label' => '认证日志',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'user_id' => [
            'label' => '用户',
        ],
        'ip_address' => [
            'label' => 'IP地址',
        ],
        'user_agent' => [
            'label' => '用户代理',
        ],
        'login_at' => [
            'label' => '登录时间',
        ],
        'logout_at' => [
            'label' => '登出时间',
        ],
        'login_method' => [
            'label' => '登录方式',
        ],
        'success' => [
            'label' => '成功',
        ],
    ],
    'actions' => [
        'view_details' => [
            'label' => '查看详情',
        ],
        'export_logs' => [
            'label' => '导出日志',
        ],
    ],
];
