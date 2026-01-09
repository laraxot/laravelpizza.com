<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Importación',
        'group' => 'Importaciones',
        'icon' => 'heroicon-o-arrow-up-tray',
        'sort' => 26,
    ],
    'label' => 'Importación',
    'plural_label' => 'Importaciones',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'job_id' => [
            'label' => 'ID de Trabajo',
        ],
        'importable_type' => [
            'label' => 'Tipo Importable',
        ],
        'file_path' => [
            'label' => 'Ruta del Archivo',
        ],
        'status' => [
            'label' => 'Estado',
        ],
        'created_at' => [
            'label' => 'Creado En',
        ],
        'completed_at' => [
            'label' => 'Completado En',
        ],
    ],
    'actions' => [
        'import' => [
            'label' => 'Importar',
        ],
        'upload' => [
            'label' => 'Cargar',
        ],
        'create' => [
            'label' => 'Crear',
        ],
    ],
];
