<?php

return [
    'actions' => [
        'create' => [
            'label' => 'Crea Job',
            'icon' => 'heroicon-o-plus',
            'tooltip' => 'Crea un nuovo job',
        ],
        'edit' => [
            'label' => 'Modifica Job',
            'icon' => 'heroicon-o-pencil',
            'tooltip' => 'Modifica il job',
        ],
        'delete' => [
            'label' => 'Elimina Job',
            'icon' => 'heroicon-o-trash',
            'tooltip' => 'Elimina il job',
        ],
        'view' => [
            'label' => 'Visualizza Job',
            'icon' => 'heroicon-o-eye',
            'tooltip' => 'Visualizza i dettagli del job',
        ],
        'retry' => [
            'label' => 'Riprova',
            'icon' => 'heroicon-o-arrow-path',
            'tooltip' => 'Riprova l\'esecuzione del job',
        ],
        'cancel' => [
            'label' => 'Annulla',
            'icon' => 'heroicon-o-x-circle',
            'tooltip' => 'Annulla il job',
        ],
        'pause' => [
            'label' => 'Pausa',
            'icon' => 'heroicon-o-pause',
            'tooltip' => 'Metti in pausa il job',
        ],
        'resume' => [
            'label' => 'Riprendi',
            'icon' => 'heroicon-o-play',
            'tooltip' => 'Riprendi l\'esecuzione del job',
        ],
        'clear_failed' => [
            'label' => 'Pulisci Falliti',
            'icon' => 'heroicon-o-trash',
            'tooltip' => 'Elimina tutti i job falliti',
        ],
        'retry_failed' => [
            'label' => 'Riprova Falliti',
            'icon' => 'heroicon-o-arrow-path',
            'tooltip' => 'Riprova tutti i job falliti',
        ],
    ],
    'messages' => [
        'created' => 'Job creato con successo',
        'updated' => 'Job aggiornato con successo',
        'deleted' => 'Job eliminato con successo',
        'retried' => 'Job riprovato con successo',
        'cancelled' => 'Job annullato con successo',
        'paused' => 'Job messo in pausa',
        'resumed' => 'Job ripreso con successo',
        'cleared_failed' => 'Job falliti eliminati con successo',
        'retried_failed' => 'Job falliti riprovati con successo',
        'error' => 'Si è verificato un errore durante l\'operazione',
        'not_found' => 'Job non trovato',
        'already_running' => 'Il job è già in esecuzione',
        'cannot_cancel' => 'Impossibile annullare il job',
        'cannot_pause' => 'Impossibile mettere in pausa il job',
    ],
    'statuses' => [
        'pending' => 'In Attesa',
        'processing' => 'In Elaborazione',
        'completed' => 'Completato',
        'failed' => 'Fallito',
        'cancelled' => 'Annullato',
        'retrying' => 'Riprova',
        'paused' => 'In Pausa',
    ],
    'types' => [
        'import' => 'Importazione',
        'export' => 'Esportazione',
        'email' => 'Email',
        'notification' => 'Notifica',
        'report' => 'Report',
        'backup' => 'Backup',
        'cleanup' => 'Pulizia',
        'sync' => 'Sincronizzazione',
        'maintenance' => 'Manutenzione',
        'analysis' => 'Analisi',
    ],
    'priorities' => [
        'low' => 'Bassa',
        'normal' => 'Normale',
        'high' => 'Alta',
        'urgent' => 'Urgente',
    ],
    'filters' => [
        'status' => [
            'label' => 'Per Stato',
            'tooltip' => 'Filtra per stato del job',
        ],
        'type' => [
            'label' => 'Per Tipo',
            'tooltip' => 'Filtra per tipo di job',
        ],
        'priority' => [
            'label' => 'Per Priorità',
            'tooltip' => 'Filtra per priorità',
        ],
        'queue' => [
            'label' => 'Per Coda',
            'tooltip' => 'Filtra per coda',
        ],
        'date_range' => [
            'label' => 'Intervallo Date',
            'start_date' => 'Data Inizio',
            'end_date' => 'Data Fine',
            'tooltip' => 'Filtra per intervallo di date',
        ],
        'failed_only' => [
            'label' => 'Solo Falliti',
            'tooltip' => 'Mostra solo job falliti',
        ],
    ],
    'bulk_actions' => [
        'retry_selected' => [
            'label' => 'Riprova Selezionati',
            'icon' => 'heroicon-o-arrow-path',
        ],
        'cancel_selected' => [
            'label' => 'Annulla Selezionati',
            'icon' => 'heroicon-o-x-circle',
        ],
        'delete_selected' => [
            'label' => 'Elimina Selezionati',
            'icon' => 'heroicon-o-trash',
        ],
        'pause_selected' => [
            'label' => 'Pausa Selezionati',
            'icon' => 'heroicon-o-pause',
        ],
        'resume_selected' => [
            'label' => 'Riprendi Selezionati',
            'icon' => 'heroicon-o-play',
        ],
    ],
    'notifications' => [
        'job_started' => 'Job iniziato',
        'job_completed' => 'Job completato',
        'job_failed' => 'Job fallito',
        'job_cancelled' => 'Job annullato',
        'job_retried' => 'Job riprovato',
    ],
    'validation' => [
        'name' => [
            'required' => 'Il nome del job è obbligatorio',
            'max' => 'Il nome non può superare :max caratteri',
        ],
        'type' => [
            'required' => 'Il tipo è obbligatorio',
            'in' => 'Tipo di job non valido',
        ],
        'priority' => [
            'required' => 'La priorità è obbligatoria',
            'in' => 'Priorità non valida',
        ],
        'scheduled_at' => [
            'date' => 'La data di programmazione deve essere una data valida',
            'after' => 'La data di programmazione deve essere nel futuro',
        ],
        'max_retries' => [
            'integer' => 'Il numero massimo di riprove deve essere un numero intero',
            'min' => 'Il numero massimo di riprove deve essere almeno :min',
        ],
    ],
    'model' => [
        'label' => 'Job',
        'plural' => 'Jobs',
        'description' => 'Gestione dei processi in background',
    ],
    'search_placeholder' => 'Cerca per nome, tipo o stato...',
    'label' => 'Job',
    'plural_label' => 'Job (Plurale)',
];
