<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Gestor de Trabajos',
        'group' => 'Trabajos',
        'icon' => 'heroicon-o-cog',
        'sort' => 43,
    ],
    'label' => 'Gestor de Trabajos',
    'plural_label' => 'Gestores de Trabajos',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'name' => [
            'label' => 'Nombre',
        ],
        'queue' => [
            'label' => 'Cola',
        ],
        'status' => [
            'label' => 'Estado',
        ],
        'progress' => [
            'label' => 'Progreso',
        ],
        'started_at' => [
            'label' => 'Iniciado En',
        ],
        'last_heartbeat' => [
            'label' => 'Último Latido',
        ],
        'created_at' => [
            'label' => 'Creado En',
        ],
        'updated_at' => [
            'label' => 'Actualizado En',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Crear',
        ],
        'restart' => [
            'label' => 'Reiniciar',
        ],
        'pause' => [
            'label' => 'Pausar',
        ],
        'resume' => [
            'label' => 'Reanudar',
        ],
    ],
];
