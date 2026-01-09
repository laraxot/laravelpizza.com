<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Programación',
        'group' => 'Herramientas',
        'icon' => 'heroicon-o-calendar',
        'sort' => 31,
    ],
    'label' => 'Programación',
    'plural_label' => 'Programaciones',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'command' => [
            'label' => 'Comando',
        ],
        'expression' => [
            'label' => 'Expresión Cron',
        ],
        'description' => [
            'label' => 'Descripción',
        ],
        'timezone' => [
            'label' => 'Zona horaria',
        ],
        'status' => [
            'label' => 'Estado',
        ],
        'created_at' => [
            'label' => 'Creado en',
        ],
        'updated_at' => [
            'label' => 'Actualizado en',
        ],
    ],
    'actions' => [
        'run' => [
            'label' => 'Ejecutar',
        ],
        'enable' => [
            'label' => 'Habilitar',
        ],
        'disable' => [
            'label' => 'Deshabilitar',
        ],
    ],
];