<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Monitor Jobs',
        'plural' => 'Monitor Jobs',
        'group' => [
            'name' => 'Sistema',
            'description' => 'Gestione e monitoraggio dei jobs di sistema',
        ],
        'label' => 'Monitor Jobs',
        'sort' => '72',
        'icon' => 'job-monitor-animated',
    ],
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'tooltip' => 'Nome del job monitorato',
            'placeholder' => 'Inserisci nome del job',
            'helper_text' => '',
            'description' => '',
        ],
        'guard_name' => [
            'label' => 'Guard',
            'tooltip' => 'Guard associato al job',
            'placeholder' => 'Seleziona guard',
            'helper_text' => '',
            'description' => '',
        ],
        'permissions' => [
            'label' => 'Permessi',
            'tooltip' => 'Permessi associati al job',
            'placeholder' => 'Seleziona permessi',
            'helper_text' => '',
            'description' => '',
        ],
        'updated_at' => [
            'label' => 'Aggiornato il',
            'tooltip' => 'Data dell\'ultimo aggiornamento del job monitorato',
            'placeholder' => 'Data di aggiornamento',
            'helper_text' => '',
            'description' => '',
        ],
        'first_name' => [
            'label' => 'Nome',
            'tooltip' => 'Nome dell\'utente che gestisce il job',
            'placeholder' => 'Nome del responsabile',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'start' => [
            'label' => 'Avvia',
            'modal' => [
                'heading' => 'Avvia Job Monitor',
                'description' => 'Vuoi avviare il monitoraggio per questo job?',
            ],
            'messages' => [
                'success' => 'Monitoraggio avviato con successo',
            ],
            'icon' => 'play',
            'color' => 'primary',
        ],
        'pause' => [
            'label' => 'Pausa',
            'modal' => [
                'heading' => 'Pausa Job Monitor',
                'description' => 'Vuoi mettere in pausa il monitoraggio di questo job?',
            ],
            'messages' => [
                'success' => 'Monitoraggio messo in pausa con successo',
            ],
            'icon' => 'pause',
            'color' => 'warning',
        ],
        'resume' => [
            'label' => 'Riprendi',
            'modal' => [
                'heading' => 'Riprendi Job Monitor',
                'description' => 'Vuoi riprendere il monitoraggio di questo job?',
            ],
            'messages' => [
                'success' => 'Monitoraggio ripreso con successo',
            ],
            'icon' => 'redo',
            'color' => 'success',
        ],
        'stop' => [
            'label' => 'Ferma',
            'modal' => [
                'heading' => 'Ferma Job Monitor',
                'description' => 'Sei sicuro di voler fermare il monitoraggio di questo job?',
            ],
            'messages' => [
                'success' => 'Monitoraggio fermato con successo',
            ],
            'icon' => 'stop',
            'color' => 'danger',
        ],
    ],
    'messages' => [
        'no_jobs' => 'Nessun job monitorato al momento',
        'job_started' => 'Monitoraggio del job avviato',
        'job_paused' => 'Monitoraggio del job messo in pausa',
        'job_resumed' => 'Monitoraggio del job ripreso',
        'job_stopped' => 'Monitoraggio del job fermato',
    ],
    'title' => 'job monitor',
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
];
