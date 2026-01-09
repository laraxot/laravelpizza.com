<?php

declare(strict_types=1);

return [
    'actions' => [
        'create' => [
            'label' => 'Crear',
        ],
    ],
    'fields' => [
        'status' => [
            'label' => 'Estado',
        ],
        'name' => [
            'label' => 'Nombre',
        ],
        'queue' => [
            'label' => 'Cola',
        ],
        'progress' => [
            'label' => 'Progreso',
        ],
        'started_at' => [
            'label' => 'Iniciado En',
        ],
    ],
    'navigation' => [
        'sort' => 87,
        'icon' => 'heroicon-o-cog-6-tooth',
        'group' => 'Sistema',
        'label' => 'Gestor de Trabajos',
    ],
];
