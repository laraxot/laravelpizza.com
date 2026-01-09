<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Gestor de trabajos',
        'group' => 'Trabajos',
        'icon' => 'heroicon-o-cog',
        'sort' => 43,
    ],
    'label' => 'Gestor de trabajos',
    'plural_label' => 'Gestores de trabajos',
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
        'last_heartbeat' => [
            'label' => 'Último latido',
        ],
        'created_at' => [
            'label' => 'Creado en',
        ],
        'updated_at' => [
            'label' => 'Actualizado en',
        ],
    ],
    'actions' => [
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