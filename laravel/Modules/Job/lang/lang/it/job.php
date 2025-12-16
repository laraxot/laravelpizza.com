<?php

declare(strict_types=1);

return [
    // NAVIGATION & STRUCTURE
    'navigation' => [
        'label' => 'Job',
        'plural_label' => 'Job',
        'group' => 'Sistema',
        'icon' => 'heroicon-o-cpu-chip',
        'sort' => 50,
        'badge' => 'Gestione processi in background',
    ],
    // MODEL INFORMATION
    'model' => [
        'label' => 'Job',
        'plural' => 'Job',
        'description' => 'Processi in background e code di elaborazione',
    ],
    // FIELDS - STRUTTURA ESPANSA OBBLIGATORIA
    'fields' => [
        'id' => [
            'label' => 'ID',
            'tooltip' => 'Identificativo univoco del job',
            'helper_text' => 'Identificativo numerico univoco del job nel sistema',
        ],
        'queue' => [
            'label' => 'Coda',
            'placeholder' => 'Inserisci il nome della coda',
            'tooltip' => 'Nome della coda di elaborazione',
            'helper_text' => 'Coda specifica in cui il job è stato accodato per l\'elaborazione',
            'help' => 'Specifica la coda di priorità per l\'elaborazione',
        ],
        'payload' => [
            'label' => 'Payload',
            'placeholder' => 'Dati del job',
            'tooltip' => 'Dati e parametri del job',
            'helper_text' => 'Informazioni e dati specifici necessari per l\'esecuzione del job',
            'help' => 'Contiene i dati serializzati necessari per l\'esecuzione',
        ],
        'attempts' => [
            'label' => 'Tentativi',
            'placeholder' => 'Numero di tentativi',
            'tooltip' => 'Numero di tentativi di esecuzione',
            'helper_text' => 'Numero di volte che il job è stato tentato di eseguire',
            'help' => 'Indica quante volte il job ha tentato l\'esecuzione',
        ],
        'reserved_at' => [
            'label' => 'Riservato alle',
            'tooltip' => 'Data di riserva del job',
            'helper_text' => 'Data e ora in cui il job è stato riservato per l\'esecuzione',
        ],
        'available_at' => [
            'label' => 'Disponibile alle',
            'placeholder' => 'Data di disponibilità',
            'tooltip' => 'Data di disponibilità per l\'esecuzione',
            'helper_text' => 'Data e ora in cui il job diventa disponibile per l\'esecuzione',
            'help' => 'Specifica quando il job può essere elaborato',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
            'tooltip' => 'Data di creazione del job',
            'helper_text' => 'Data e ora in cui il job è stato creato nel sistema',
        ],
        'updated_at' => [
            'label' => 'Ultima Modifica',
            'tooltip' => 'Data dell\'ultima modifica',
            'helper_text' => 'Data e ora dell\'ultimo aggiornamento del job',
        ],
    ],
    // ACTIONS - STRUTTURA ESPANSA OBBLIGATORIA
    'actions' => [
        'create' => [
            'label' => 'Nuovo Job',
            'icon' => 'heroicon-o-plus',
            'color' => 'primary',
            'tooltip' => 'Crea un nuovo job',
            'modal' => [
                'heading' => 'Crea Nuovo Job',
                'description' => 'Inserisci i dettagli per il nuovo job',
                'confirm' => 'Crea Job',
                'cancel' => 'Annulla',
            ],
            'messages' => [
                'success' => 'Job creato con successo',
                'error' => 'Si è verificato un errore durante la creazione del job',
            ],
        ],
        'edit' => [
            'label' => 'Modifica Job',
            'icon' => 'heroicon-o-pencil',
            'color' => 'warning',
            'tooltip' => 'Modifica il job selezionato',
            'modal' => [
                'heading' => 'Modifica Job',
                'description' => 'Aggiorna le informazioni del job',
                'confirm' => 'Salva modifiche',
                'cancel' => 'Annulla',
            ],
            'messages' => [
                'success' => 'Job modificato con successo',
                'error' => 'Si è verificato un errore durante la modifica del job',
            ],
        ],
        'delete' => [
            'label' => 'Elimina Job',
            'icon' => 'heroicon-o-trash',
            'color' => 'danger',
            'tooltip' => 'Elimina il job selezionato',
            'modal' => [
                'heading' => 'Elimina Job',
                'description' => 'Sei sicuro di voler eliminare questo job? Questa azione è irreversibile.',
                'confirm' => 'Elimina',
                'cancel' => 'Annulla',
            ],
            'messages' => [
                'success' => 'Job eliminato con successo',
                'error' => 'Si è verificato un errore durante l\'eliminazione del job',
            ],
            'confirmation' => 'Sei sicuro di voler eliminare questo job?',
        ],
        'retry' => [
            'label' => 'Riprova Job',
            'icon' => 'heroicon-o-arrow-path',
            'color' => 'info',
            'tooltip' => 'Riprova l\'esecuzione del job',
            'modal' => [
                'heading' => 'Riprova Job',
                'description' => 'Sei sicuro di voler riprovare l\'esecuzione di questo job?',
                'confirm' => 'Riprova',
                'cancel' => 'Annulla',
            ],
            'messages' => [
                'success' => 'Job rimesso in coda per la ri-esecuzione',
                'error' => 'Si è verificato un errore durante il rinvio del job',
            ],
        ],
        'view' => [
            'label' => 'Visualizza Job',
            'icon' => 'heroicon-o-eye',
            'color' => 'secondary',
            'tooltip' => 'Visualizza i dettagli del job',
        ],
        'bulk_actions' => [
            'delete' => [
                'label' => 'Elimina Selezionati',
                'icon' => 'heroicon-o-trash',
                'color' => 'danger',
                'tooltip' => 'Elimina tutti i job selezionati',
                'modal' => [
                    'heading' => 'Elimina Job Selezionati',
                    'description' => 'Sei sicuro di voler eliminare i job selezionati? Questa azione è irreversibile.',
                    'confirm' => 'Elimina tutti',
                    'cancel' => 'Annulla',
                ],
                'messages' => [
                    'success' => 'Job eliminati con successo',
                    'error' => 'Si è verificato un errore durante l\'eliminazione dei job',
                ],
            ],
            'retry' => [
                'label' => 'Riprova Selezionati',
                'icon' => 'heroicon-o-arrow-path',
                'color' => 'info',
                'tooltip' => 'Riprova l\'esecuzione dei job selezionati',
                'modal' => [
                    'heading' => 'Riprova Job Selezionati',
                    'description' => 'Sei sicuro di voler riprovare l\'esecuzione dei job selezionati?',
                    'confirm' => 'Riprova tutti',
                    'cancel' => 'Annulla',
                ],
                'messages' => [
                    'success' => 'Job rimessi in coda per la ri-esecuzione',
                    'error' => 'Si è verificato un errore durante il rinvio dei job',
                ],
            ],
        ],
    ],
    // SECTIONS - ORGANIZZAZIONE FORM
    'sections' => [
        'basic_info' => [
            'label' => 'Informazioni Base',
            'description' => 'Informazioni fondamentali del job',
            'icon' => 'heroicon-o-information-circle',
        ],
        'execution' => [
            'label' => 'Esecuzione',
            'description' => 'Dettagli di esecuzione e scheduling',
            'icon' => 'heroicon-o-clock',
        ],
        'payload' => [
            'label' => 'Payload',
            'description' => 'Dati e parametri del job',
            'icon' => 'heroicon-o-document-text',
        ],
    ],
    // FILTERS - RICERCA E FILTRI
    'filters' => [
        'queue' => [
            'label' => 'Coda',
            'placeholder' => 'Seleziona coda',
        ],
        'status' => [
            'label' => 'Stato',
            'options' => [
                'pending' => 'In attesa',
                'running' => 'In esecuzione',
                'failed' => 'Fallito',
                'completed' => 'Completato',
            ],
        ],
        'attempts' => [
            'label' => 'Tentativi',
            'placeholder' => 'Filtra per tentativi',
        ],
        'date_range' => [
            'label' => 'Periodo',
            'placeholder' => 'Seleziona il periodo',
        ],
    ],
    // MESSAGES - FEEDBACK UTENTE
    'messages' => [
        'empty_state' => 'Nessun job trovato',
        'search_placeholder' => 'Cerca job...',
        'loading' => 'Caricamento job in corso...',
        'total_count' => 'Totale job: :count',
        'created' => 'Job creato con successo',
        'updated' => 'Job aggiornato con successo',
        'deleted' => 'Job eliminato con successo',
        'retried' => 'Job rimesso in coda per la ri-esecuzione',
        'bulk_deleted' => 'Job eliminati con successo',
        'bulk_retried' => 'Job rimessi in coda per la ri-esecuzione',
        'error_general' => 'Si è verificato un errore. Riprova più tardi.',
        'error_validation' => 'Si sono verificati errori di validazione.',
        'error_permission' => 'Non hai i permessi per eseguire questa azione.',
        'success_operation' => 'Operazione completata con successo',
    ],
    // VALIDATION - MESSAGGI DI VALIDAZIONE
    'validation' => [
        'queue_required' => 'La coda è obbligatoria',
        'payload_required' => 'Il payload è obbligatorio',
        'attempts_numeric' => 'I tentativi devono essere numerici',
        'attempts_min' => 'I tentativi devono essere almeno :min',
        'available_at_required' => 'La data di disponibilità è obbligatoria',
        'available_at_after' => 'La data di disponibilità deve essere futura',
    ],
    // DESCRIPTIONS - DESCRIZIONI CONTESTUALI
    'descriptions' => [
        'job_purpose' => 'Gestione dei processi in background e code di elaborazione',
        'queue_system' => 'Sistema di code per l\'elaborazione asincrona dei task',
        'retry_mechanism' => 'Meccanismo di ri-tentativo per job falliti',
        'monitoring' => 'Monitoraggio dello stato e delle performance dei job',
    ],
    // OPTIONS - OPZIONI E VALORI PREDEFINITI
    'options' => [
        'queues' => [
            'default' => 'Default',
            'high' => 'Alta Priorità',
            'low' => 'Bassa Priorità',
            'emails' => 'Email',
            'notifications' => 'Notifiche',
            'reports' => 'Report',
        ],
        'statuses' => [
            'pending' => 'In attesa',
            'running' => 'In esecuzione',
            'failed' => 'Fallito',
            'completed' => 'Completato',
        ],
        'priorities' => [
            'high' => 'Alta',
            'normal' => 'Normale',
            'low' => 'Bassa',
        ],
    ],
];
