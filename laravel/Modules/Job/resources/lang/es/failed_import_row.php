<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Fila de Importación Fallida',
        'group' => 'Filas de Importación',
        'icon' => 'heroicon-o-exclamation-circle',
        'sort' => 28,
    ],
    'label' => 'Fila de Importación Fallida',
    'plural_label' => 'Filas de Importación Fallidas',
    'fields' => [
        'id' => [
            'label' => 'ID',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'import_batch_id' => [
            'label' => 'ID de Lote de Importación',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'row_index' => [
            'label' => 'Índice de Fila',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'errors' => [
            'label' => 'Errores',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'data' => [
            'label' => 'Datos',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'created_at' => [
            'label' => 'Creado En',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'view_errors' => [
            'label' => 'Ver Errores',
        ],
        'fix_row' => [
            'label' => 'Corregir Fila',
        ],
    ],
];
