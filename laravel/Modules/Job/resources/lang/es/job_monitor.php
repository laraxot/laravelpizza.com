<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Monitor de trabajos',
        'group' => 'Trabajos',
        'icon' => 'heroicon-o-chart-bar',
        'sort' => 44,
    ],
    'label' => 'Monitor de trabajos',
    'plural_label' => 'Monitores de trabajos',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'job_id' => [
            'label' => 'Trabajo',
        ],
        'status' => [
            'label' => 'Estado',
        ],
        'progress' => [
            'label' => 'Progreso',
        ],
        'start_time' => [
            'label' => 'Hora de inicio',
        ],
        'end_time' => [
            'label' => 'Hora de finalización',
        ],
        'estimated_completion' => [
            'label' => 'Finalización estimada',
        ],
        'created_at' => [
            'label' => 'Creado en',
        ],
    ],
    'actions' => [
        'view_progress' => [
            'label' => 'Ver progreso',
        ],
        'cancel_job' => [
            'label' => 'Cancelar trabajo',
        ],
    ],
];