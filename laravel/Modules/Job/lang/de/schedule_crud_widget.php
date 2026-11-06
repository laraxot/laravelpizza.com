<?php

declare(strict_types=1);

return [
    'sections' => [
        'tasks' => [
            'title' => 'Geplante Aufgaben',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Neue Aufgabe',
        ],
        'run_now' => [
            'label' => 'Jetzt ausführen',
        ],
    ],
    'fields' => [
        'description' => [
            'label' => 'Beschreibung',
        ],
        'average_runtime' => [
            'label' => 'Durchschnittliche Laufzeit',
        ],
        'last_run' => [
            'label' => 'Letzte Ausführung',
        ],
        'next_run' => [
            'label' => 'Nächste Ausführung',
        ],
    ],
    'messages' => [
        'runtime_seconds' => [
            'message' => ':seconds Sekunden',
        ],
        'no_tasks' => [
            'message' => 'Keine Aufgaben gefunden.',
        ],
    ],
];
