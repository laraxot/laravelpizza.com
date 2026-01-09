<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Trabajos en espera',
        'group' => 'Trabajos',
        'icon' => 'heroicon-o-clock',
        'sort' => 30,
    ],
    'label' => 'Trabajo en espera',
    'plural_label' => 'Trabajos en espera',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'connection' => [
            'label' => 'Conexión',
        ],
        'queue' => [
            'label' => 'Cola',
        ],
        'payload' => [
            'label' => 'Contenido',
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
    'actions' => [
        'process' => [
            'label' => 'Procesar',
        ],
        'retry' => [
            'label' => 'Reintentar',
        ],
    ],
];