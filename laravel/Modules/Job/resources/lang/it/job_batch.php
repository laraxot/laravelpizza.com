<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Batch di lavoro',
        'group' => 'Batch',
        'icon' => 'heroicon-o-queue-list',
        'sort' => 29,
    ],
    'label' => 'Batch di lavoro',
    'plural_label' => 'Batch di lavoro',
    'fields' => [
        'id' => [
            'label' => 'ID',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'name' => [
            'label' => 'Nome',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'total_jobs' => [
            'label' => 'Lavori totali',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'pending_jobs' => [
            'label' => 'Lavori in sospeso',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'failed_jobs' => [
            'label' => 'Lavori falliti',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'failed_job_ids' => [
            'label' => 'ID lavori falliti',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'options' => [
            'label' => 'Opzioni',
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
        'finished_at' => [
            'label' => 'Completato il',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'view_details' => [
            'label' => 'Visualizza dettagli',
        ],
        'cancel' => [
            'label' => 'Annulla',
        ],
    ],
];
