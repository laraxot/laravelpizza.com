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
        'ip_address' => [
            'label' => 'IP地址',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'user_agent' => [
            'label' => '用户代理',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'login_at' => [
            'label' => '登录时间',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'logout_at' => [
            'label' => '注销时间',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'login_method' => [
            'label' => '登录方法',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'success' => [
            'label' => '成功',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'view_details' => [
            'label' => '查看详情',
        ],
        'export_logs' => [
            'label' => '导出日志',
        ],
        'reorderRecords' => [
            'tooltip' => '重新排序记录',
        ],
    ],
];
