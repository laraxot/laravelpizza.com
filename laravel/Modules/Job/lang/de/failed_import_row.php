<?php

declare(strict_types=1);

return [
    'pages' => 'Pagine',
    'widgets' => 'Widgets',
    'navigation' => [
        'name' => 'Jobs Import Falliti',
        'plural' => 'Jobs Import Falliti',
        'group' => [
            'name' => 'Sistema',
            'description' => 'Gestione e recupero dei jobs falliti',
        ],
        'label' => 'Jobs Import Falliti',
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
        'attempts' => [
            'label' => 'Tentativi',
        ],
        'max_attempts' => [
            'label' => 'Tentativi Massimi',
        ],
        'status' => [
            'label' => 'Stato',
        ],
        'created_at' => [
            'label' => 'Creato il',
        ],
        'updated_at' => [
            'label' => 'Aggiornato il',
        ],
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
                'error' => 'Errore durante il riavvio del job',
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
                'error' => 'Errore durante il riavvio dei jobs',
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
                'error' => 'Errore durante l\'eliminazione del job',
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
                'error' => 'Errore durante l\'eliminazione dei jobs',
            ],
        ],
        'clear' => [
            'label' => 'Pulisci Tutto',
            'modal' => [
                'heading' => 'Pulisci Jobs Falliti',
                'description' => 'Sei sicuro di voler eliminare tutti i jobs falliti?',
            ],
            'messages' => [
                'success' => 'Jobs puliti con successo',
                'error' => 'Errore durante la pulizia dei jobs',
            ],
        ],
    ],
    'messages' => [
        'no_jobs' => 'Nessun job fallito trovato',
        'import_success' => 'Importazione completata con successo',
        'import_error' => 'Errore durante l\'importazione',
        'row_error' => 'Errore nella riga :row: :error',
    ],
    'status' => [
        'pending' => 'In attesa',
        'processing' => 'In elaborazione',
        'failed' => 'Fallito',
        'completed' => 'Completato',
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
];
