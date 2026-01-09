<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Surveillance des tâches',
        'group' => 'Tâches',
        'icon' => 'heroicon-o-chart-bar',
        'sort' => 44,
    ],
    'label' => 'Surveillance des tâches',
    'plural_label' => 'Surveillances des tâches',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'job_id' => [
            'label' => 'Tâche',
        ],
        'status' => [
            'label' => 'Statut',
        ],
        'progress' => [
            'label' => 'Progression',
        ],
        'start_time' => [
            'label' => 'Heure de début',
        ],
        'end_time' => [
            'label' => 'Heure de fin',
        ],
        'estimated_completion' => [
            'label' => 'Fin estimée',
        ],
        'created_at' => [
            'label' => 'Créé le',
        ],
    ],
    'actions' => [
        'view_progress' => [
            'label' => 'Voir la progression',
        ],
        'cancel_job' => [
            'label' => 'Annuler la tâche',
        ],
    ],
];