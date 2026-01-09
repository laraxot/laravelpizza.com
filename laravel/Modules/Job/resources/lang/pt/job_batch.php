<?php

declare(strict_types=1);

return [
    'actions' => [
        'prune_batches' => [
            'label' => 'Limpar Lotes',
        ],
    ],
    'fields' => [
        'failed_job_ids' => [
            'label' => 'IDs de Trabalhos Falhados',
        ],
    ],
    'navigation' => [
        'sort' => 85,
        'icon' => 'heroicon-o-queue-list',
        'group' => 'Sistema',
        'label' => 'Lotes de Trabalhos',
    ],
];
