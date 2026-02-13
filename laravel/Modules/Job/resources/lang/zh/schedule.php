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
        ],
        'command' => [
            'label' => '命令',
        ],
        'expression' => [
            'label' => 'Cron表达式',
        ],
        'description' => [
            'label' => '描述',
        ],
        'timezone' => [
            'label' => '时区',
        ],
        'status' => [
            'label' => '状态',
        ],
        'created_at' => [
            'label' => '创建时间',
        ],
        'updated_at' => [
            'label' => '更新时间',
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
