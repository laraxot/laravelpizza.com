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
        ],
        'job_id' => [
            'label' => 'Lavoro',
        ],
        'status' => [
            'label' => 'Stato',
        ],
        'progress' => [
            'label' => 'Progresso',
        ],
        'start_time' => [
            'label' => 'Ora inizio',
        ],
        'end_time' => [
            'label' => 'Ora fine',
        ],
        'estimated_completion' => [
            'label' => 'Completamento stimato',
        ],
        'created_at' => [
            'label' => 'Creato il',
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
