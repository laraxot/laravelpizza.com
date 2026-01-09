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
        ],
        'name' => [
            'label' => 'Nome',
        ],
        'total_jobs' => [
            'label' => 'Lavori totali',
        ],
        'pending_jobs' => [
            'label' => 'Lavori in sospeso',
        ],
        'failed_jobs' => [
            'label' => 'Lavori falliti',
        ],
        'failed_job_ids' => [
            'label' => 'ID lavori falliti',
        ],
        'options' => [
            'label' => 'Opzioni',
        ],
        'created_at' => [
            'label' => 'Creato il',
        ],
        'finished_at' => [
            'label' => 'Completato il',
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