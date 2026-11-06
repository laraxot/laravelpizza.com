<?php

declare(strict_types=1);

return [
    'view' => [
        'running_notice' => [
            'message' => 'El comando se está ejecutando. No cierres esta ventana.',
        ],
        'actions_disabled' => [
            'description' => 'Las demás acciones están deshabilitadas hasta que finalice el comando.',
        ],
        'running_command' => [
            'message' => 'Ejecutando comando: php artisan',
        ],
        'waiting_output' => [
            'message' => 'Esperando la salida...',
        ],
        'select_command' => [
            'label' => 'Selecciona un comando en el encabezado para empezar.',
        ],
        'scroll' => [
            'helper_text' => 'Usa la rueda del ratón para desplazarte por la salida.',
        ],
    ],
    'status' => [
        'completed' => [
            'message' => 'Completado',
        ],
        'failed' => [
            'message' => 'Fallido',
        ],
        'running' => [
            'message' => 'Ejecutando...',
        ],
    ],
];
