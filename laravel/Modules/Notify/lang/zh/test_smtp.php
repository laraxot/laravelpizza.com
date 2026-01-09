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
        ],
        'name' => [
            'label' => '名称',
        ],
        'host' => [
            'label' => '主机',
        ],
        'port' => [
            'label' => '端口',
        ],
        'username' => [
            'label' => '用户名',
        ],
        'password' => [
            'label' => '密码',
        ],
        'encryption' => [
            'label' => '加密',
        ],
        'from_address' => [
            'label' => '发件人地址',
        ],
        'from_name' => [
            'label' => '发件人名称',
        ],
        'status' => [
            'label' => '状态',
        ],
        'last_tested_at' => [
            'label' => '最后测试时间',
        ],
        'created_at' => [
            'label' => '创建时间',
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
