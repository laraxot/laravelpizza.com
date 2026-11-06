<?php

declare(strict_types=1);

return [
    'sections' => [
        'tasks' => [
            'title' => 'Tareas programadas',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Nueva tarea',
        ],
        'run_now' => [
            'label' => 'Ejecutar ahora',
        ],
    ],
    'fields' => [
        'description' => [
            'label' => 'Descripción',
        ],
        'average_runtime' => [
            'label' => 'Duración media',
        ],
        'last_run' => [
            'label' => 'Última ejecución',
        ],
        'next_run' => [
            'label' => 'Próxima ejecución',
        ],
    ],
    'messages' => [
        'runtime_seconds' => [
            'message' => ':seconds segundos',
        ],
        'no_tasks' => [
            'message' => 'No se encontraron tareas.',
        ],
    ],
];
