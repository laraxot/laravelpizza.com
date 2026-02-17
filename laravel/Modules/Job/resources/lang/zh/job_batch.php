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
        'total_jobs' => [
            'label' => '总任务数',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'pending_jobs' => [
            'label' => '待处理任务',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'failed_jobs' => [
            'label' => '失败任务',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'failed_job_ids' => [
            'label' => '失败任务ID',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'options' => [
            'label' => '选项',
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
        'finished_at' => [
            'label' => '完成时间',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
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
