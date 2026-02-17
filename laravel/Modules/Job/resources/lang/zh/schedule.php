<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => '计划任务',
        'group' => '工具',
        'icon' => 'heroicon-o-calendar',
        'sort' => 31,
    ],
    'label' => '计划任务',
    'plural_label' => '计划任务',
    'fields' => [
        'id' => [
            'label' => 'ID',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'command' => [
            'label' => '命令',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'expression' => [
            'label' => 'Cron表达式',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'description' => [
            'label' => '描述',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'timezone' => [
            'label' => '时区',
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
        'created_at' => [
            'label' => '创建时间',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'updated_at' => [
            'label' => '更新时间',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'run' => [
            'label' => '运行',
        ],
        'enable' => [
            'label' => '启用',
        ],
        'disable' => [
            'label' => '禁用',
        ],
    ],
];
