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
        ],
        'job_id' => [
            'label' => '任务',
        ],
        'status' => [
            'label' => '状态',
        ],
        'progress' => [
            'label' => '进度',
        ],
        'start_time' => [
            'label' => '开始时间',
        ],
        'end_time' => [
            'label' => '结束时间',
        ],
        'estimated_completion' => [
            'label' => '预计完成时间',
        ],
        'created_at' => [
            'label' => '创建时间',
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
