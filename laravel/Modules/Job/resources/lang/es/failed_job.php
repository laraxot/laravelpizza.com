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
        'exception' => [
            'label' => 'Excepción',
        ],
        'failed_at' => [
            'label' => 'Fallido En',
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
