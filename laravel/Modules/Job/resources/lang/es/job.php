<?php

declare(strict_types=1);

return [
    'actions' => [
        'create' => [
            'label' => 'Crear',
        ],
        'logout' => [
            'tooltip' => 'Cerrar sesión',
            'icon' => 'heroicon-o-arrow-left-on-rectangle',
            'label' => 'Cerrar sesión',
        ],
        'cancel' => [
            'tooltip' => 'Cancelar',
        ],
        'reorderRecords' => [
            'tooltip' => 'Reordenar registros',
        ],
    ],
    'fields' => [
        'edit' => [
            'label' => 'Editar',
        ],
        'payload' => [
            'label' => 'Contenido',
        ],
        'id' => [
            'label' => 'ID',
        ],
        'queue' => [
            'label' => 'Cola',
        ],
        'attempts' => [
            'label' => 'Intentos',
        ],
        'reserved_at' => [
            'label' => 'Reservado en',
        ],
        'available_at' => [
            'label' => 'Disponible en',
        ],
        'created_at' => [
            'label' => 'Creado en',
        ],
    ],
    'navigation' => [
        'sort' => 58,
        'icon' => 'heroicon-o-cog',
        'group' => 'Trabajos',
        'label' => 'Trabajo',
    ],
    'label' => 'Trabajo',
    'plural_label' => 'Trabajos',
];
