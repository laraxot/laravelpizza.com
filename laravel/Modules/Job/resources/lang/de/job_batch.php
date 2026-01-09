<?php

declare(strict_types=1);

return [
    'actions' => [
        'prune_batches' => [
            'label' => 'Batches Bereinigen',
        ],
    ],
    'fields' => [
        'failed_job_ids' => [
            'label' => 'IDs Fehlgeschlagener Aufträge',
        ],
    ],
    'navigation' => [
        'sort' => 85,
        'icon' => 'heroicon-o-queue-list',
        'group' => 'System',
        'label' => 'Auftragsgruppen',
    ],
];
