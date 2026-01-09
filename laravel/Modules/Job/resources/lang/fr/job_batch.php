<?php

declare(strict_types=1);

return [
    'actions' => [
        'prune_batches' => [
            'label' => 'Nettoyer les Lots',
        ],
    ],
    'fields' => [
        'failed_job_ids' => [
            'label' => 'IDs des Emplois Échoués',
        ],
    ],
    'navigation' => [
        'sort' => 85,
        'icon' => 'heroicon-o-queue-list',
        'group' => 'Système',
        'label' => 'Lots d\'Emplois',
    ],
];
