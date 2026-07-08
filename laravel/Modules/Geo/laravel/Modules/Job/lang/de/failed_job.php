<?php

declare(strict_types=1);

return [
    'pages' => 'Pagine',
    'widgets' => 'Widgets',
    'navigation' => [
        'name' => 'Jobs Falliti',
        'plural' => 'Jobs Falliti',
        'group' => [
            'name' => 'Sistema',
            'description' => 'Gestione e recupero dei jobs falliti',
        ],
        'label' => 'Jobs Falliti',
        'sort' => '93',
        'icon' => 'job-failed-job',
    ],
    'model' => [
        'label' => 'Job Fallito',
        'plural' => [
            'label' => 'Jobs Falliti',
        ],
    ],
    'fields' => [
        'id' => [
            'label' => 'ID',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'uuid' => [
            'label' => 'UUID',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'connection' => [
            'label' => 'Connessione',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'queue' => [
            'label' => 'Coda',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'payload' => [
            'label' => 'Payload',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'exception' => [
            'label' => 'Eccezione',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'failed_at' => [
            'label' => 'Fallito il',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'attempts' => [
            'label' => 'Tentativi',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'max_attempts' => [
            'label' => 'Tentativi Massimi',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'status' => [
            'label' => 'Stato',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'created_at' => [
            'label' => 'Creato il',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'updated_at' => [
            'label' => 'Aggiornato il',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'toggleColumns' => [
            'label' => 'toggleColumns',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'retry' => [
            'label' => 'Riprova',
            'modal' => [
                'heading' => 'Riprova Job',
                'description' => 'Vuoi riprovare ad eseguire questo job?',
            ],
            'messages' => [
                'success' => 'Job riavviato con successo',
            ],
        ],
        'retry_all' => [
            'label' => 'Riprova Tutti',
            'modal' => [
                'heading' => 'Riprova Tutti i Jobs',
                'description' => 'Vuoi riprovare tutti i jobs falliti?',
            ],
            'messages' => [
                'success' => 'Jobs riavviati con successo',
            ],
        ],
        'delete' => [
            'label' => 'Elimina',
            'modal' => [
                'heading' => 'Elimina Job',
                'description' => 'Sei sicuro di voler eliminare questo job fallito?',
            ],
            'messages' => [
                'success' => 'Job eliminato con successo',
            ],
        ],
        'delete_all' => [
            'label' => 'Elimina Tutti',
            'modal' => [
                'heading' => 'Elimina Tutti i Jobs',
                'description' => 'Sei sicuro di voler eliminare tutti i jobs falliti?',
            ],
            'messages' => [
                'success' => 'Jobs eliminati con successo',
            ],
        ],
        'clear' => [
            'label' => 'Pulisci Tutto',
            'modal' => [
                'heading' => 'Pulisci Jobs Falliti',
                'description' => 'Sei sicuro di voler eliminare tutti i jobs falliti?',
            ],
            'messages' => [
                'success' => 'Jobs falliti eliminati con successo',
            ],
        ],
    ],
    'messages' => [
        'no_failed_jobs' => 'Nessun job fallito',
        'retry_success' => 'Job riavviato con successo',
        'retry_all_success' => 'Tutti i jobs sono stati riavviati con successo',
        'delete_success' => 'Job eliminato con successo',
        'delete_all_success' => 'Tutti i jobs sono stati eliminati con successo',
        'clear_success' => 'Jobs falliti eliminati con successo',
        'max_attempts_exceeded' => 'Il job ha superato il numero massimo di tentativi',
        'job_not_found' => 'Job non trovato',
        'invalid_payload' => 'Payload non valido',
    ],
    'statuses' => [
        'pending' => 'In Attesa',
        'processing' => 'In Elaborazione',
        'failed' => 'Fallito',
        'completed' => 'Completato',
        'cancelled' => 'Annullato',
        'max_attempts' => 'Tentativi Massimi Superati',
    ],
    'error_types' => [
        'max_attempts' => 'Tentativi Massimi Superati',
        'timeout' => 'Timeout',
        'memory_limit' => 'Limite Memoria Superato',
        'connection' => 'Errore di Connessione',
        'queue' => 'Errore di Coda',
        'payload' => 'Errore nel Payload',
        'system' => 'Errore di Sistema',
    ],
    'plural' => [
        'model' => [
            'label' => 'failed job.plural.model',
        ],
        'label' => 'Jobs Falliti',
        'sort' => '93',
        'icon' => 'job-failed-job',
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
];
