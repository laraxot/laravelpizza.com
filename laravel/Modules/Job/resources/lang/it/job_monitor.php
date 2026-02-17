<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Monitoraggio lavoro',
        'group' => 'Lavori',
        'icon' => 'heroicon-o-chart-bar',
        'sort' => 44,
    ],
    'label' => 'Monitoraggio lavoro',
    'plural_label' => 'Monitoraggi lavoro',
    'fields' => [
        'id' => [
            'label' => 'ID',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'job_id' => [
            'label' => 'Lavoro',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'status' => [
            'label' => 'Stato',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'progress' => [
            'label' => 'Progresso',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'start_time' => [
            'label' => 'Ora inizio',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'end_time' => [
            'label' => 'Ora fine',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'estimated_completion' => [
            'label' => 'Completamento stimato',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'created_at' => [
            'label' => 'Creato il',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'view_progress' => [
            'label' => 'Visualizza progresso',
        ],
        'cancel_job' => [
            'label' => 'Annulla lavoro',
        ],
    ],
];
