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
        'sort' => 93,
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
        ],
        'uuid' => [
            'label' => 'UUID',
        ],
        'connection' => [
            'label' => 'Connessione',
        ],
        'queue' => [
            'label' => 'Coda',
        ],
        'payload' => [
            'label' => 'Payload',
        ],
        'exception' => [
            'label' => 'Eccezione',
        ],
        'failed_at' => [
            'label' => 'Fallito il',
        ],
        'attempts' => 'Tentativi',
        'max_attempts' => 'Tentativi Massimi',
        'status' => 'Stato',
        'created_at' => 'Creato il',
        'updated_at' => 'Aggiornato il',
        'toggleColumns' => [
            'label' => 'toggleColumns',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
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
        'logout' => [
            'tooltip' => 'logout',
            'icon' => 'logout',
            'label' => 'logout',
        ],
        'reorderRecords' => [
            'tooltip' => 'reorderRecords',
            'icon' => 'reorderRecords',
            'label' => 'reorderRecords',
        ],
        'cancel' => [
            'tooltip' => 'cancel',
            'icon' => 'cancel',
            'label' => 'cancel',
        ],
        'openColumnManager' => [
            'tooltip' => 'openColumnManager',
            'icon' => 'openColumnManager',
            'label' => 'openColumnManager',
        ],
        'submit' => [
            'tooltip' => 'submit',
            'icon' => 'submit',
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
        'sort' => 93,
        'icon' => 'job-failed-job',
    ],
    'label' => 'failed job',
    'plural_label' => 'Failed Job (Plurale)',
];
