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
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'job_id' => [
            'label' => 'ID del trabajo',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'exportable_type' => [
            'label' => 'Tipo exportable',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'file_path' => [
            'label' => 'Ruta del archivo',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'format' => [
            'label' => 'Formato',
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
        'created_at' => [
            'label' => 'Creado en',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'completed_at' => [
            'label' => 'Completado en',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
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
