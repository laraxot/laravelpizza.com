<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'SMTP测试',
        'group' => '通知',
        'icon' => 'heroicon-o-envelope-open',
        'sort' => 47,
    ],
    'label' => 'SMTP测试',
    'plural_label' => 'SMTP测试',
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
        'host' => [
            'label' => '主机',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'port' => [
            'label' => '端口',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'username' => [
            'label' => '用户名',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'password' => [
            'label' => '密码',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'encryption' => [
            'label' => '加密',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'from_address' => [
            'label' => '发件人地址',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'from_name' => [
            'label' => '发件人名称',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'status' => [
            'label' => '状态',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'last_tested_at' => [
            'label' => '最后测试时间',
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
    ],
    'actions' => [
        'send_test_email' => [
            'label' => '发送测试邮件',
        ],
        'test_connection' => [
            'label' => '测试连接',
        ],
    ],
];
