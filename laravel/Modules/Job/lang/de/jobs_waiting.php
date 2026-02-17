<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Jobs in Attesa',
        'plural' => 'Jobs in Attesa',
        'group' => [
            'name' => 'Sistema',
            'description' => 'Monitoraggio dei jobs in coda',
        ],
        'label' => 'Jobs in Attesa',
        'sort' => '15',
        'icon' => 'heroicon-o-cog',
    ],
    'fields' => [
        'id' => [
            'label' => 'ID',
            'tooltip' => 'Identificativo univoco del job',
            'placeholder' => 'ID del job',
            'helper_text' => '',
            'description' => '',
        ],
        'queue' => [
            'label' => 'Coda',
            'tooltip' => 'Nome della coda del job',
            'placeholder' => 'Seleziona la coda',
            'helper_text' => '',
            'description' => '',
        ],
        'payload' => [
            'label' => 'Payload',
            'tooltip' => 'Dati associati al job',
            'placeholder' => 'Carica i dati del job',
            'helper_text' => '',
            'description' => '',
        ],
        'attempts' => [
            'label' => 'Tentativi',
            'tooltip' => 'Numero di tentativi di esecuzione',
            'placeholder' => 'Tentativi eseguiti',
            'helper_text' => '',
            'description' => '',
        ],
        'reserved_at' => [
            'label' => 'Riservato il',
            'tooltip' => 'Data e ora in cui il job è stato riservato',
            'placeholder' => 'Seleziona la data',
            'helper_text' => '',
            'description' => '',
        ],
        'available_at' => [
            'label' => 'Disponibile il',
            'tooltip' => 'Data e ora di disponibilità del job',
            'placeholder' => 'Seleziona la data',
            'helper_text' => '',
            'description' => '',
        ],
        'created_at' => [
            'label' => 'Creato il',
            'tooltip' => 'Data di creazione del job',
            'placeholder' => 'Data di creazione',
            'helper_text' => '',
            'description' => '',
        ],
        'status' => [
            'label' => 'Stato',
            'tooltip' => 'Stato attuale del job',
            'placeholder' => 'Seleziona stato',
            'helper_text' => '',
            'description' => '',
        ],
        'priority' => [
            'label' => 'Priorità',
            'tooltip' => 'Priorità del job',
            'placeholder' => 'Seleziona priorità',
            'helper_text' => '',
            'description' => '',
        ],
        'type' => [
            'label' => 'Tipo',
            'tooltip' => 'Tipo di job (Importazione, Esportazione, etc.)',
            'placeholder' => 'Seleziona tipo',
            'helper_text' => '',
            'description' => '',
        ],
        'name' => [
            'label' => 'Nome',
            'tooltip' => 'Nome del job',
            'placeholder' => 'Inserisci il nome del job',
            'helper_text' => '',
            'description' => '',
        ],
        'description' => [
            'label' => 'Descrizione',
            'tooltip' => 'Descrizione del job',
            'placeholder' => 'Inserisci la descrizione',
            'helper_text' => '',
            'description' => '',
        ],
        'delay' => [
            'label' => 'Ritardo',
            'tooltip' => 'Tempo di ritardo prima che il job venga eseguito',
            'placeholder' => 'Inserisci il ritardo',
            'helper_text' => '',
            'description' => '',
        ],
        'timeout' => [
            'label' => 'Timeout',
            'tooltip' => 'Tempo massimo di esecuzione del job',
            'placeholder' => 'Inserisci il timeout',
            'helper_text' => '',
            'description' => '',
        ],
        'tags' => [
            'label' => 'Tags',
            'tooltip' => 'Etichette associate al job',
            'placeholder' => 'Inserisci i tags',
            'helper_text' => '',
            'description' => '',
        ],
        'first_name' => [
            'label' => 'Nome',
            'tooltip' => 'Nome dell\'utente',
            'placeholder' => 'Inserisci il nome',
            'helper_text' => '',
            'description' => '',
        ],
        'last_name' => [
            'label' => 'Cognome',
            'tooltip' => 'Cognome dell\'utente',
            'placeholder' => 'Inserisci il cognome',
            'helper_text' => '',
            'description' => '',
        ],
        'select_all' => [
            'label' => 'Seleziona Tutti',
            'tooltip' => 'Seleziona tutti gli elementi disponibili',
            'placeholder' => '',
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
        'import' => [
            'label' => 'Importa',
            'tooltip' => 'Importa dati da un file XLS o CSV',
            'icon' => 'import-icon',
            'color' => 'blue',
            'fields' => [
                'import_file' => [
                    'label' => 'Seleziona un file XLS o CSV da caricare',
                    'tooltip' => 'Seleziona un file da caricare per l\'importazione',
                    'placeholder' => 'Scegli un file',
                ],
            ],
        ],
        'export' => [
            'label' => 'Esporta',
            'tooltip' => 'Esporta i dati in un file',
            'icon' => 'export-icon',
            'color' => 'green',
            'filename_prefix' => 'Aree al',
            'columns' => [
                'name' => [
                    'label' => 'Nome area',
                    'tooltip' => 'Nome dell\'area da esportare',
                ],
                'parent_name' => [
                    'label' => 'Nome area livello superiore',
                    'tooltip' => 'Nome dell\'area di livello superiore',
                ],
            ],
        ],
        'process' => [
            'label' => 'Processa',
            'tooltip' => 'Processa il job in attesa',
            'icon' => 'play-circle',
            'color' => 'green',
            'modal' => [
                'heading' => 'Processa Job',
                'description' => 'Vuoi processare questo job in attesa?',
            ],
            'messages' => [
                'success' => 'Job processato con successo',
            ],
        ],
        'cancel' => [
            'label' => 'Cancella',
            'tooltip' => 'Cancella il job in attesa',
            'icon' => 'delete-icon',
            'color' => 'red',
            'modal' => [
                'heading' => 'Cancella Job',
                'description' => 'Vuoi cancellare questo job in attesa?',
            ],
            'messages' => [
                'success' => 'Job cancellato con successo',
            ],
        ],
        'retry' => [
            'label' => 'Riprova',
            'tooltip' => 'Riprova il job fallito',
            'icon' => 'redo',
            'color' => 'yellow',
            'modal' => [
                'heading' => 'Riprova Job',
                'description' => 'Vuoi riprovare questo job?',
            ],
            'messages' => [
                'success' => 'Job riprovato con successo',
            ],
        ],
    ],
    'messages' => [
        'no_jobs' => 'Nessun job in attesa',
        'job_processed' => 'Job processato',
        'job_cancelled' => 'Job cancellato',
        'job_retried' => 'Job riprovato',
    ],
    'statuses' => [
        'waiting' => 'In Attesa',
        'reserved' => 'Riservato',
        'delayed' => 'Ritardato',
        'ready' => 'Pronto',
    ],
    'priorities' => [
        'low' => 'Bassa',
        'normal' => 'Normale',
        'high' => 'Alta',
        'urgent' => 'Urgente',
    ],
    'types' => [
        'default' => 'Default',
        'scheduled' => 'Schedulato',
        'recurring' => 'Ricorrente',
        'batch' => 'Batch',
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
];
