<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Lot de tâches',
        'group' => 'Lots',
        'icon' => 'heroicon-o-queue-list',
        'sort' => 29,
    ],
    'label' => 'Lot de tâches',
    'plural_label' => 'Lots de tâches',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'name' => [
            'label' => 'Nom',
        ],
        'total_jobs' => [
            'label' => 'Tâches totales',
        ],
        'pending_jobs' => [
            'label' => 'Tâches en attente',
        ],
        'failed_jobs' => [
            'label' => 'Tâches échouées',
        ],
        'failed_job_ids' => [
            'label' => 'IDs des tâches échouées',
        ],
        'options' => [
            'label' => 'Options',
        ],
        'created_at' => [
            'label' => 'Créé le',
        ],
        'finished_at' => [
            'label' => 'Terminé le',
        ],
    ],
    'actions' => [
        'view_details' => [
            'label' => 'Voir les détails',
        ],
        'cancel' => [
            'label' => 'Annuler',
        ],
    ],
];