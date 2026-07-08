<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Fase Progetto',
        'plural' => 'Fasi Progetti',
        'group' => [
            'name' => 'Incentivi',
            'description' => 'Gestione delle fasi dei progetti',
        ],
        'label' => 'fasi_progetti',
        'sort' => 72,
        'icon' => 'incentivi-project-phases',
    ],
    'fields' => [
        'progetto' => [
            'label' => 'Progetto',
            'placeholder' => 'Seleziona il progetto',
            'help' => 'Progetto di riferimento',
        ],
        'fase' => [
            'nome' => [
                'label' => 'Nome Fase',
                'placeholder' => 'Inserisci il nome della fase',
                'help' => 'Nome identificativo della fase',
            ],
            'descrizione' => [
                'label' => 'Descrizione',
                'placeholder' => 'Inserisci la descrizione',
                'help' => 'Descrizione dettagliata della fase',
            ],
            'ordine' => [
                'label' => 'Ordine',
                'placeholder' => 'Inserisci l\'ordine',
                'help' => 'Ordine di esecuzione della fase',
            ],
        ],
        'periodo' => [
            'data_inizio' => [
                'label' => 'Data Inizio',
                'placeholder' => 'Seleziona la data di inizio',
                'help' => 'Data di inizio della fase',
            ],
            'data_fine' => [
                'label' => 'Data Fine',
                'placeholder' => 'Seleziona la data di fine',
                'help' => 'Data di fine della fase',
            ],
            'durata' => [
                'label' => 'Durata',
                'help' => 'Durata prevista in giorni',
            ],
        ],
        'stato' => [
            'label' => 'Stato',
            'placeholder' => 'Seleziona lo stato',
            'help' => 'Stato attuale della fase',
            'options' => [
                'pianificata' => 'Pianificata',
                'in_corso' => 'In Corso',
                'completata' => 'Completata',
                'sospesa' => 'Sospesa',
                'annullata' => 'Annullata',
            ],
        ],
        'risorse' => [
            'budget' => [
                'label' => 'Budget',
                'placeholder' => 'Inserisci il budget',
                'help' => 'Budget allocato per la fase',
            ],
            'personale' => [
                'label' => 'Personale',
                'placeholder' => 'Seleziona il personale',
                'help' => 'Personale assegnato alla fase',
            ],
        ],
        'deliverables' => [
            'label' => 'Deliverables',
            'placeholder' => 'Inserisci i deliverables',
            'help' => 'Risultati attesi dalla fase',
        ],
        'dipendenze' => [
            'label' => 'Dipendenze',
            'placeholder' => 'Seleziona le dipendenze',
            'help' => 'Fasi da cui dipende',
        ],
        'toggleColumns' => [
            'label' => 'toggleColumns',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
        ],
        'openFilters' => [
            'label' => 'openFilters',
        ],
        'end_date' => [
            'label' => 'end_date',
            'description' => 'end_date',
            'helper_text' => 'end_date',
            'placeholder' => 'end_date',
        ],
        'start_date' => [
            'label' => 'start_date',
            'description' => 'start_date',
            'helper_text' => 'start_date',
            'placeholder' => 'start_date',
        ],
        'description' => [
            'label' => 'description',
            'description' => 'description',
            'helper_text' => 'description',
            'placeholder' => 'description',
        ],
        'name' => [
            'label' => 'name',
            'description' => 'name',
            'helper_text' => 'name',
            'placeholder' => 'name',
        ],
        'detach' => [
            'label' => 'detach',
        ],
        'edit' => [
            'label' => 'edit',
        ],
        'view' => [
            'label' => 'view',
        ],
        'nuova-fase' => [
            'label' => 'nuova-fase',
        ],
        'handlePhaseSettlements' => [
            'label' => 'handlePhaseSettlements',
        ],
        'handleSettlement' => [
            'label' => 'handleSettlement',
        ],
        'create' => [
            'label' => 'create',
        ],
        'settlement' => [
            'importo' => [
                'label' => 'settlement.importo',
            ],
            'denominazione' => [
                'label' => 'settlement.denominazione',
            ],
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Nuova Fase',
            'success' => 'Fase creata con successo',
            'error' => 'Errore durante la creazione',
        ],
        'update' => [
            'label' => 'Modifica',
            'success' => 'Fase aggiornata con successo',
            'error' => 'Errore durante l\'aggiornamento',
        ],
        'delete' => [
            'label' => 'Elimina',
            'success' => 'Fase eliminata con successo',
            'error' => 'Errore durante l\'eliminazione',
            'confirm' => 'Sei sicuro di voler eliminare questa fase?',
        ],
        'start' => [
            'label' => 'Avvia',
            'success' => 'Fase avviata con successo',
            'error' => 'Errore durante l\'avvio',
        ],
        'complete' => [
            'label' => 'Completa',
            'success' => 'Fase completata con successo',
            'error' => 'Errore durante il completamento',
        ],
    ],
    'messages' => [
        'validation' => [
            'nome' => [
                'required' => 'Il nome è obbligatorio',
                'unique' => 'Questo nome è già in uso',
            ],
            'ordine' => [
                'required' => 'L\'ordine è obbligatorio',
                'numeric' => 'L\'ordine deve essere numerico',
                'min' => 'L\'ordine deve essere maggiore di zero',
            ],
            'date' => [
                'required' => 'Le date sono obbligatorie',
                'date' => 'Le date devono essere valide',
                'after' => 'La data di fine deve essere successiva all\'inizio',
            ],
        ],
        'errors' => [
            'dependencies_incomplete' => 'Dipendenze non completate',
            'resources_unavailable' => 'Risorse non disponibili',
            'invalid_sequence' => 'Sequenza non valida',
            'overlap_dates' => 'Date sovrapposte con altre fasi',
        ],
        'warnings' => [
            'budget_low' => 'Budget quasi esaurito',
            'deadline_approaching' => 'Scadenza imminente',
            'resource_overallocation' => 'Risorse sovrallocate',
        ],
        'info' => [
            'dependencies_ok' => 'Tutte le dipendenze soddisfatte',
            'resources_allocated' => 'Risorse allocate correttamente',
            'timeline_updated' => 'Timeline aggiornata',
        ],
    ],
    'title' => 'project phases',
];
