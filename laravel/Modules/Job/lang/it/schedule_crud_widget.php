<?php

declare(strict_types=1);

return [
    'sections' => [
        'tasks' => [
            'title' => 'Attività pianificate',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Nuova attività',
        ],
        'run_now' => [
            'label' => 'Esegui ora',
        ],
    ],
    'fields' => [
        'description' => [
            'label' => 'Descrizione',
        ],
        'average_runtime' => [
            'label' => 'Durata media',
        ],
        'last_run' => [
            'label' => 'Ultima esecuzione',
        ],
        'next_run' => [
            'label' => 'Prossima esecuzione',
        ],
    ],
    'messages' => [
        'runtime_seconds' => [
            'message' => ':seconds secondi',
        ],
        'no_tasks' => [
            'message' => 'Nessuna attività trovata.',
        ],
    ],
];
