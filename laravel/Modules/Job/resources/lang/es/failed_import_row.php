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
        ],
        'import_batch_id' => [
            'label' => 'ID de Lote de Importación',
        ],
        'row_index' => [
            'label' => 'Índice de Fila',
        ],
        'errors' => [
            'label' => 'Errores',
        ],
        'data' => [
            'label' => 'Datos',
        ],
        'created_at' => [
            'label' => 'Creado En',
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
