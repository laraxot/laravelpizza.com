<?php

declare(strict_types=1);
// Job translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// claude-audit static: pages/widgets/navigation slice (fields → job_fields.php).
// Canon: Modules/Job/docs/wiki — domain i18n only.

return [
    'pages' => [
        'index' => [
            'title' => 'Elenco Jobs',
            'subtitle' => 'Gestione dei processi in background',
            'description' => 'Visualizza e gestisci tutti i job del sistema',
        ],
        'create' => [
            'title' => 'Nuovo Job',
            'subtitle' => 'Crea un nuovo job',
            'description' => 'Inserisci i dettagli per creare un nuovo job',
        ],
        'edit' => [
            'title' => 'Modifica Job',
            'subtitle' => 'Modifica i dettagli del job',
            'description' => 'Aggiorna le informazioni del job selezionato',
        ],
        'view' => [
            'title' => 'Dettagli Job',
            'subtitle' => 'Visualizza i dettagli completi del job',
            'description' => 'Informazioni dettagliate sul job selezionato',
        ],
    ],
    'widgets' => [
        'job_overview' => [
            'title' => 'Panoramica Jobs',
            'description' => 'Statistiche sui job del sistema',
        ],
        'recent_jobs' => [
            'title' => 'Jobs Recenti',
            'description' => 'Ultimi job eseguiti',
        ],
        'failed_jobs' => [
            'title' => 'Jobs Falliti',
            'description' => 'Jobs che hanno avuto errori',
        ],
    ],
    'navigation' => [
        'name' => 'Job',
        'plural' => 'Jobs',
        'group' => [
            'name' => 'Jobs',
            'description' => 'Gestione dei processi in background',
        ],
        'label' => 'Jobs',
        'sort' => 30,
        'icon' => 'heroicon-o-cpu-chip',
        'tooltip' => 'Gestisci i processi in background',
        'helper_text' => '',
    ],
];
