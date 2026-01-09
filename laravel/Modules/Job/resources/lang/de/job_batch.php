<?php

declare(strict_types=1);

return [
    'actions' => [
        'prune_batches' => [
            'label' => 'Chargen bereinigen',
        ],
    ],
    'fields' => [
        'failed_job_ids' => [
            'label' => 'Fehlgeschlagene Auftrags-IDs',
        ],
    ],
    'navigation' => [
        'sort' => 85,
        'icon' => 'job batch.navigation',
        'group' => 'job batch.navigation',
        'label' => 'job batch.navigation',
    ],
];
