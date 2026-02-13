<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => '任务批次',
        'group' => '批次',
        'icon' => 'heroicon-o-queue-list',
        'sort' => 29,
    ],
    'label' => '任务批次',
    'plural_label' => '任务批次',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'name' => [
            'label' => '名称',
        ],
        'total_jobs' => [
            'label' => '总任务数',
        ],
        'pending_jobs' => [
            'label' => '待处理任务',
        ],
        'failed_jobs' => [
            'label' => '失败任务',
        ],
        'failed_job_ids' => [
            'label' => '失败任务ID',
        ],
        'options' => [
            'label' => '选项',
        ],
        'created_at' => [
            'label' => '创建时间',
        ],
        'finished_at' => [
            'label' => '完成时间',
        ],
    ],
    'actions' => [
        'view_details' => [
            'label' => '查看详情',
        ],
        'cancel' => [
            'label' => '取消',
        ],
    ],
];
