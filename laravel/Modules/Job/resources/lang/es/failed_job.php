<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Trabajo Fallido',
        'group' => 'Trabajos Fallidos',
        'icon' => 'heroicon-o-exclamation-triangle',
        'sort' => 27,
    ],
    'label' => 'Trabajo Fallido',
    'plural_label' => 'Trabajos Fallidos',
    'fields' => [
        'id' => [
            'label' => 'ID',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'connection' => [
            'label' => 'Conexión',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'queue' => [
            'label' => 'Cola',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'payload' => [
            'label' => 'Carga Útil',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'exception' => [
            'label' => 'Excepción',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'failed_at' => [
            'label' => 'Fallido En',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'retry' => [
            'label' => 'Reintentar',
        ],
        'delete' => [
            'label' => 'Eliminar',
        ],
        'retry_all' => [
            'label' => 'Reintentar Todos',
        ],
        'delete_all' => [
            'label' => 'Eliminar Todos',
        ],
    ],
];
