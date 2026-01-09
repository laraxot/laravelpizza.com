<?php

declare(strict_types=1);

return [
    'fields' => [
        'status' => [
            'label' => 'Estado',
        ],
        'display_name' => [
            'label' => 'Nombre para Mostrar',
        ],
        'queue' => [
            'label' => 'Cola',
        ],
        'attempts' => [
            'label' => 'Intentos',
        ],
        'reserved_at' => [
            'label' => 'Reservado En',
        ],
        'created_at' => [
            'label' => 'Creado En',
        ],
    ],
    'navigation' => [
        'sort' => 91,
        'icon' => 'heroicon-o-clock',
        'group' => 'Sistema',
        'label' => 'Trabajos en Espera',
    ],