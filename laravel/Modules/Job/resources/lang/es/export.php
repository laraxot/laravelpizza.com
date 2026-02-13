<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Exportación',
        'group' => 'Exportaciones',
        'icon' => 'heroicon-o-arrow-down-tray',
        'sort' => 25,
    ],
    'label' => 'Exportación',
    'plural_label' => 'Exportaciones',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'job_id' => [
            'label' => 'ID del trabajo',
        ],
        'exportable_type' => [
            'label' => 'Tipo exportable',
        ],
        'file_path' => [
            'label' => 'Ruta del archivo',
        ],
        'format' => [
            'label' => 'Formato',
        ],
        'status' => [
            'label' => 'Estado',
        ],
        'created_at' => [
            'label' => 'Creado en',
        ],
        'completed_at' => [
            'label' => 'Completado en',
        ],
    ],
    'actions' => [
        'export' => [
            'label' => 'Exportar',
        ],
        'download' => [
            'label' => 'Descargar',
        ],
    ],
];
