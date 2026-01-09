<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Estado del trabajo',
        'group' => 'Trabajos',
        'icon' => 'heroicon-o-status-online',
        'sort' => 45,
    ],
    'label' => 'Estado del trabajo',
    'plural_label' => 'Estados del trabajo',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'name' => [
            'label' => 'Nombre',
        ],
        'description' => [
            'label' => 'Descripción',
        ],
        'color' => [
            'label' => 'Color',
        ],
        'created_at' => [
            'label' => 'Creado en',
        ],
        'updated_at' => [
            'label' => 'Actualizado en',
        ],
    ],
    'actions' => [
        'update_status' => [
            'label' => 'Actualizar estado',
        ],
        'assign_to_job' => [
            'label' => 'Asignar al trabajo',
        ],
    ],
];