<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => '任务监控',
        'group' => '任务',
        'icon' => 'heroicon-o-chart-bar',
        'sort' => 44,
    ],
    'label' => '任务监控',
    'plural_label' => '任务监控',
    'fields' => [
        'id' => [
            'label' => 'ID',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'job_id' => [
            'label' => '任务',
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
        'progress' => [
            'label' => '进度',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'start_time' => [
            'label' => '开始时间',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'end_time' => [
            'label' => '结束时间',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'estimated_completion' => [
            'label' => '预计完成时间',
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
        'view_progress' => [
            'label' => '查看进度',
        ],
        'cancel_job' => [
            'label' => '取消任务',
        ],
    ],
];
