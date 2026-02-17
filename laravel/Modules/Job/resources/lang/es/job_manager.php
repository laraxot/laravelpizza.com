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
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'name' => [
            'label' => 'Nombre',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'queue' => [
            'label' => 'Cola',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'status' => [
            'label' => 'Estado',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'progress' => [
            'label' => 'Progreso',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'started_at' => [
            'label' => 'Iniciado En',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'last_heartbeat' => [
            'label' => 'Último Latido',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'created_at' => [
            'label' => 'Creado En',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'updated_at' => [
            'label' => 'Actualizado En',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
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
