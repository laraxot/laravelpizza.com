<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Eventi Archiviati',
        'plural' => 'Eventi Archiviati',
        'group' => [
            'name' => 'Monitoraggio',
            'description' => 'Gestione degli eventi di sistema archiviati',
        ],
        'label' => 'Eventi Archiviati',
        'sort' => 62,
        'icon' => 'activity-stored-event-animated',
    ],
    'fields' => [
        'id' => [
            'label' => 'ID',
            'help' => 'Identificativo unico dell\'evento archiviato',
            'validation' => 'required|integer|min:1',
        ],
        'event_class' => [
            'label' => 'Classe Evento',
            'placeholder' => 'Inserisci la classe dell\'evento',
            'help' => 'Nome completo della classe che rappresenta l\'evento',
            'validation' => 'required|string|max:255',
            'searchable' => true,
        ],
        'event_properties' => [
            'label' => 'Proprietà Evento',
            'placeholder' => 'Proprietà dell\'evento',
            'help' => 'Dati e proprietà specifiche dell\'evento',
            'validation' => 'required|json',
            'type' => 'json',
            'format' => 'json',
        ],
        'aggregate_uuid' => [
            'label' => 'UUID Aggregato',
            'placeholder' => 'UUID dell\'aggregato',
            'help' => 'Identificativo unico dell\'aggregato di appartenenza',
            'validation' => 'required|uuid',
            'searchable' => true,
        ],
        'aggregate_version' => [
            'label' => 'Versione Aggregato',
            'placeholder' => 'Inserisci la versione',
            'help' => 'Numero di versione dell\'aggregato',
            'validation' => 'required|integer|min:1',
            'sortable' => true,
        ],
        'event_version' => [
            'label' => 'Versione Evento',
            'placeholder' => 'Versione dell\'evento',
            'help' => 'Numero di versione del formato evento',
            'validation' => 'nullable|string|max:20',
        ],
        'meta_data' => [
            'label' => 'Metadata',
            'placeholder' => 'Metadata aggiuntivi',
            'help' => 'Informazioni metadata aggiuntive sull\'evento',
            'validation' => 'nullable|json',
            'type' => 'json',
            'format' => 'json',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
            'placeholder' => 'Seleziona data e ora',
            'help' => 'Timestamp di quando l\'evento è stato creato',
            'validation' => 'required|date',
            'format' => 'd/m/Y H:i:s',
            'sortable' => true,
        ],
        'created_by' => [
            'label' => 'Creato Da',
            'placeholder' => 'Utente creatore',
            'help' => 'Utente che ha generato l\'evento',
            'validation' => 'nullable|integer|exists:users,id',
            'searchable' => true,
        ],
        'updated_by' => [
            'label' => 'Aggiornato Da',
            'placeholder' => 'Utente aggiornatore',
            'help' => 'Utente che ha aggiornato l\'evento',
            'validation' => 'nullable|integer|exists:users,id',
        ],
        'stream_name' => [
            'label' => 'Nome Stream',
            'placeholder' => 'Nome del flusso di eventi',
            'help' => 'Identificativo del flusso a cui appartiene l\'evento',
            'validation' => 'nullable|string|max:255',
            'searchable' => true,
        ],
        'stream_position' => [
            'label' => 'Posizione Stream',
            'placeholder' => 'Posizione nel flusso',
            'help' => 'Posizione sequenziale dell\'evento nel flusso',
            'validation' => 'nullable|integer|min:0',
            'sortable' => true,
        ],
        'toggleColumns' => [
            'label' => 'Mostra/Nascondi Colonne',
            'placeholder' => '',
            'help' => 'Configura la visibilità delle colonne nella tabella',
        ],
    ],
    'filters' => [
        'event_class' => [
            'label' => 'Classe Evento',
            'placeholder' => 'Filtra per classe',
            'help' => 'Filtra gli eventi per tipo di classe',
            'type' => 'select',
            'searchable' => true,
            'multiple' => true,
        ],
        'aggregate_uuid' => [
            'label' => 'UUID Aggregato',
            'placeholder' => 'Filtra per aggregato',
            'help' => 'Filtra gli eventi per UUID aggregato',
            'type' => 'text',
            'validation' => 'nullable|uuid',
        ],
        'aggregate_version_range' => [
            'label' => 'Range Versione Aggregato',
            'placeholder' => 'Da versione - A versione',
            'help' => 'Filtra per range di versioni dell\'aggregato',
            'type' => 'number_range',
        ],
        'date_range' => [
            'label' => 'Intervallo Date',
            'placeholder' => 'Seleziona intervallo',
            'help' => 'Filtra gli eventi per periodo di tempo',
            'type' => 'date_range',
            'presets' => [
                'last_hour' => 'Ultima ora',
                'today' => 'Oggi',
                'yesterday' => 'Ieri',
                'last_7_days' => 'Ultimi 7 giorni',
                'last_30_days' => 'Ultimi 30 giorni',
                'this_month' => 'Questo mese',
                'last_month' => 'Mese scorso',
            ],
        ],
        'stream_name' => [
            'label' => 'Nome Stream',
            'placeholder' => 'Filtra per stream',
            'help' => 'Filtra per nome del flusso di eventi',
            'type' => 'select',
            'searchable' => true,
        ],
        'created_by' => [
            'label' => 'Creato Da',
            'placeholder' => 'Filtra per utente',
            'help' => 'Filtra per utente creatore',
            'type' => 'select',
            'searchable' => true,
        ],
    ],
    'actions' => [
        'view' => [
            'label' => 'Visualizza',
            'success' => 'Evento caricato con successo',
            'error' => 'Errore nel caricamento dell\'evento',
        ],
        'view_json' => [
            'label' => 'Visualizza JSON',
            'icon' => 'heroicon-o-code-bracket',
            'color' => 'info',
            'success' => 'Dati JSON caricati con successo',
            'error' => 'Errore nel caricamento dei dati JSON',
        ],
        'replay' => [
            'label' => 'Replay Evento',
            'success' => 'Replay dell\'evento completato con successo',
            'error' => 'Errore durante il replay dell\'evento',
            'confirmation' => 'Sei sicuro di voler eseguire il replay di questo evento?',
            'requires_permission' => 'events.replay',
        ],
        'replay_from' => [
            'label' => 'Replay da Questo Evento',
            'icon' => 'heroicon-o-play',
            'color' => 'warning',
            'success' => 'Replay degli eventi avviato con successo',
            'error' => 'Errore durante l\'avvio del replay',
            'confirmation' => 'Vuoi eseguire il replay di tutti gli eventi a partire da questo? Operazione potenzialmente impattante.',
            'requires_permission' => 'events.replay_from',
        ],
        'export' => [
            'label' => 'Esporta Eventi',
            'success' => 'Eventi esportati con successo',
            'error' => 'Errore durante l\'esportazione',
            'confirmation' => 'Vuoi esportare gli eventi selezionati?',
        ],
        'snapshot_create' => [
            'label' => 'Crea Snapshot',
            'icon' => 'heroicon-o-camera',
            'color' => 'primary',
            'success' => 'Snapshot creato con successo',
            'error' => 'Errore nella creazione dello snapshot',
            'confirmation' => 'Vuoi creare uno snapshot dell\'aggregato a questo punto?',
            'requires_permission' => 'events.snapshot',
        ],
        'bulk_replay' => [
            'label' => 'Replay Multiplo',
            'icon' => 'heroicon-o-forward',
            'color' => 'danger',
            'success' => 'Replay multiplo completato',
            'error' => 'Errore durante il replay multiplo',
            'confirmation' => 'ATTENZIONE: Vuoi eseguire il replay di tutti gli eventi selezionati? Questa è un\'operazione critica.',
            'requires_permission' => 'events.bulk_replay',
        ],
    ],
    'messages' => [
        'no_events' => 'Nessun evento trovato',
        'event_replayed' => 'Evento riprodotto con successo',
        'events_exported' => 'Eventi esportati con successo',
        'loading' => 'Caricamento eventi in corso...',
        'error_loading' => 'Errore nel caricamento degli eventi',
        'snapshot_created' => 'Snapshot creato con successo',
        'empty_state' => [
            'title' => 'Nessun evento archiviato',
            'description' => 'Non ci sono eventi archiviati nel sistema. Gli eventi appariranno qui quando verranno generati e archiviati.',
        ],
        'replay_warning' => 'Il replay degli eventi può modificare lo stato del sistema. Procedi con cautela.',
    ],
    'export' => [
        'formats' => [
            'json' => [
                'label' => 'JSON',
                'mime_type' => 'application/json',
                'extension' => 'json',
                'icon' => 'heroicon-o-code-bracket',
            ],
            'csv' => [
                'label' => 'CSV',
                'mime_type' => 'text/csv',
                'extension' => 'csv',
                'icon' => 'heroicon-o-document-text',
            ],
            'excel' => [
                'label' => 'Excel',
                'mime_type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'extension' => 'xlsx',
                'icon' => 'heroicon-o-table-cells',
            ],
        ],
        'columns' => [
            'id' => [
                'label' => 'ID',
                'sortable' => true,
            ],
            'created_at' => [
                'label' => 'Data',
                'format' => 'd/m/Y H:i:s',
                'sortable' => true,
            ],
            'event_class' => [
                'label' => 'Classe',
                'sortable' => true,
            ],
            'aggregate_uuid' => [
                'label' => 'UUID Aggregato',
                'sortable' => false,
            ],
            'aggregate_version' => [
                'label' => 'Versione',
                'sortable' => true,
            ],
            'stream_name' => [
                'label' => 'Stream',
                'sortable' => true,
            ],
            'stream_position' => [
                'label' => 'Posizione',
                'sortable' => true,
            ],
        ],
        'filename_pattern' => 'eventi_archiviati_{date}_{time}',
        'max_records' => 50000,
        'include_properties' => false, // Per performance, escludi di default i JSON payload
    ],
    'permissions' => [
        'view' => 'stored_events.view',
        'create' => 'stored_events.create',
        'update' => 'stored_events.update',
        'delete' => 'stored_events.delete',
        'export' => 'stored_events.export',
        'replay' => 'stored_events.replay',
        'replay_from' => 'stored_events.replay_from',
        'bulk_replay' => 'stored_events.bulk_replay',
        'snapshot' => 'stored_events.snapshot',
    ],
    'pagination' => [
        'per_page' => 50,
        'options' => [25, 50, 100, 200],
        'simple' => false, // Usa paginazione completa per event sourcing
    ],
    'cache' => [
        'ttl' => 600, // 10 minuti - cache più lunga per eventi immutabili
        'tags' => ['stored_events', 'event_sourcing', 'monitoring'],
    ],
    'event_sourcing' => [
        'replay_batch_size' => 100,
        'snapshot_frequency' => 1000, // Crea snapshot ogni 1000 eventi
        'retention_days' => 2555, // ~7 anni di ritenzione per compliance
        'stream_patterns' => [
            'user' => 'user-{uuid}',
            'order' => 'order-{uuid}',
            'payment' => 'payment-{uuid}',
        ],
    ],
    'monitoring' => [
        'alert_on_replay_errors' => true,
        'alert_on_missing_events' => true,
        'performance_tracking' => true,
        'audit_trail' => true,
    ],
];
