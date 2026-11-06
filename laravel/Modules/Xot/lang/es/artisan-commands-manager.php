<?php

declare(strict_types=1);

return [
    'messages' => [
        'running_command' => [
            'message' => 'Comando en ejecución: :command',
        ],
    ],
    'status' => [
        'completed' => 'Completado',
        'failed' => 'Fallido',
        'waiting' => 'Esperando la salida...',
        'running' => 'En ejecución...',
    ],
    'hints' => [
        'running' => 'El comando se está ejecutando. La salida aparecerá en tiempo real.',
        'disabled' => 'No se pueden ejecutar otros comandos mientras hay un comando en ejecución.',
        'scroll' => 'La salida se actualiza automáticamente y se desplaza hacia abajo.',
    ],
    'select_command' => 'Selecciona un comando en el encabezado para empezar.',
];
