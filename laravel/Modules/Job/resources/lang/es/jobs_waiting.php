<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Trabajos en Espera',
        'group' => 'Trabajos',
        'icon' => 'heroicon-o-clock',
        'sort' => 30,
    ],
    'label' => 'Trabajo en Espera',
    'plural_label' => 'Trabajos en Espera',
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
            'label' => 'Carga Útil',
        ],
        'attempts' => [
            'label' => 'Intentos',
        ],
        'reserved_at' => [
            'label' => 'Reservado En',
        ],
        'available_at' => [
            'label' => 'Disponible En',
        ],
        'created_at' => [
            'label' => 'Creado En',
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
