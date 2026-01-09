<?php

declare(strict_types=1);

return [
    'actions' => [
        'prune_batches' => [
            'label' => 'Limpiar Lotes',
        ],
    ],
    'fields' => [
        'failed_job_ids' => [
            'label' => 'IDs de Trabajos Fallidos',
        ],
    ],
    'navigation' => [
        'sort' => 85,
        'icon' => 'heroicon-o-queue-list',
        'group' => 'Sistema',
        'label' => 'Lotes de Trabajos',
    ],
];
