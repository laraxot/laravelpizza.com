<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Decurtazione Assenze',
        'plural' => 'Decurtazioni Assenze',
        'group' => [
            'name' => 'Valutazione',
            'description' => 'Gestione delle decurtazioni per assenze',
        ],
        'label' => 'decurtazioni',
        'sort' => 91,
        'icon' => 'performance-deduction',
    ],
    'fields' => [
        'dipendente' => [
            'name' => [
                'label' => 'Nome Dipendente',
                'placeholder' => 'Seleziona il dipendente',
                'help' => 'Dipendente soggetto a decurtazione',
            ],
            'matricola' => [
                'label' => 'Matricola',
                'placeholder' => 'Inserisci la matricola',
                'help' => 'Codice identificativo del dipendente',
            ],
        ],
        'assenza' => [
            'tipo' => [
                'label' => 'Tipo Assenza',
                'placeholder' => 'Seleziona il tipo',
                'help' => 'Tipologia di assenza',
                'options' => [
                    'malattia' => 'Malattia',
                    'ferie' => 'Ferie',
                    'permesso' => 'Permesso',
                    'congedo' => 'Congedo',
                    'altro' => 'Altro',
                ],
            ],
            'data_inizio' => [
                'label' => 'Data Inizio',
                'placeholder' => 'Seleziona la data di inizio',
                'help' => 'Data di inizio dell\'assenza',
            ],
            'data_fine' => [
                'label' => 'Data Fine',
                'placeholder' => 'Seleziona la data di fine',
                'help' => 'Data di fine dell\'assenza',
            ],
            'giorni' => [
                'label' => 'Giorni Totali',
                'help' => 'Numero totale di giorni di assenza',
            ],
        ],
        'decurtazione' => [
            'percentuale' => [
                'label' => 'Percentuale',
                'placeholder' => 'Inserisci la percentuale',
                'help' => 'Percentuale di decurtazione',
            ],
            'importo' => [
                'label' => 'Importo',
                'placeholder' => 'Inserisci l\'importo',
                'help' => 'Importo della decurtazione',
            ],
            'motivo' => [
                'label' => 'Motivazione',
                'placeholder' => 'Inserisci la motivazione',
                'help' => 'Motivo della decurtazione',
            ],
        ],
        'stato' => [
            'label' => 'Stato',
            'help' => 'Stato attuale della decurtazione',
            'options' => [
                'bozza' => 'Bozza',
                'approvata' => 'Approvata',
                'applicata' => 'Applicata',
                'annullata' => 'Annullata',
            ],
        ],
        'timestamps' => [
            'created_at' => [
                'label' => 'Data Creazione',
                'help' => 'Data di creazione del record',
            ],
            'updated_at' => [
                'label' => 'Ultimo Aggiornamento',
                'help' => 'Data dell\'ultima modifica',
            ],
        ],
        'id' => [
            'label' => 'id',
        ],
        'anno' => [
            'label' => 'anno',
        ],
        'individuale' => [
            'nome' => [
                'label' => 'individuale.nome',
            ],
        ],
        'min_perc' => [
            'label' => 'min_perc',
        ],
        'max_perc' => [
            'label' => 'max_perc',
        ],
        'min_gg_365' => [
            'label' => 'min_gg_365',
        ],
        'max_gg_365' => [
            'label' => 'max_gg_365',
        ],
        'decurtazione_perc' => [
            'label' => 'decurtazione_perc',
        ],
        'created_at' => [
            'label' => 'created_at',
        ],
        'updated_at' => [
            'label' => 'updated_at',
        ],
        'value' => [
            'label' => 'value',
            'placeholder' => 'value',
            'helper_text' => 'value',
            'description' => 'value',
        ],
    ],
    'actions' => [
        'calculate' => [
            'label' => 'Calcola Decurtazione',
            'success' => 'Decurtazione calcolata con successo',
            'error' => 'Errore durante il calcolo',
        ],
        'approve' => [
            'label' => 'Approva',
            'success' => 'Decurtazione approvata con successo',
            'error' => 'Errore durante l\'approvazione',
        ],
        'apply' => [
            'label' => 'Applica',
            'success' => 'Decurtazione applicata con successo',
            'error' => 'Errore durante l\'applicazione',
        ],
        'cancel' => [
            'label' => 'Annulla',
            'success' => 'Decurtazione annullata con successo',
            'error' => 'Errore durante l\'annullamento',
            'confirm' => 'Sei sicuro di voler annullare questa decurtazione?',
        ],
        'logout' => [
            'tooltip' => 'logout',
            'label' => 'logout',
            'icon' => 'logout',
        ],
        'create' => [
            'label' => 'create',
            'icon' => 'create',
            'tooltip' => 'create',
        ],
        'copy_from_last_year' => [
            'label' => 'copy_from_last_year',
            'icon' => 'copy_from_last_year',
            'tooltip' => 'copy_from_last_year',
        ],
        'view' => [
            'label' => 'view',
            'icon' => 'view',
            'tooltip' => 'view',
        ],
        'edit' => [
            'label' => 'edit',
            'icon' => 'edit',
            'tooltip' => 'edit',
        ],
        'delete' => [
            'label' => 'delete',
            'icon' => 'delete',
            'tooltip' => 'delete',
        ],
        'check' => [
            'label' => 'check',
            'icon' => 'check',
            'tooltip' => 'check',
        ],
        'CheckCriterioEsclusioneBulkAction' => [
            'label' => 'CheckCriterioEsclusioneBulkAction',
            'icon' => 'CheckCriterioEsclusioneBulkAction',
            'tooltip' => 'CheckCriterioEsclusioneBulkAction',
        ],
        'layout' => [
            'label' => 'layout',
            'icon' => 'layout',
            'tooltip' => 'layout',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
            'icon' => 'applyFilters',
            'tooltip' => 'applyFilters',
        ],
        'openFilters' => [
            'label' => 'openFilters',
            'icon' => 'openFilters',
            'tooltip' => 'openFilters',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
            'icon' => 'resetFilters',
            'tooltip' => 'resetFilters',
        ],
        'applyTableColumnManager' => [
            'label' => 'applyTableColumnManager',
            'icon' => 'applyTableColumnManager',
            'tooltip' => 'applyTableColumnManager',
        ],
        'openColumnManager' => [
            'label' => 'openColumnManager',
            'icon' => 'openColumnManager',
            'tooltip' => 'openColumnManager',
        ],
        'resetColumnManager' => [
            'label' => 'resetColumnManager',
            'icon' => 'resetColumnManager',
            'tooltip' => 'resetColumnManager',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
            'icon' => 'reorderRecords',
            'tooltip' => 'reorderRecords',
        ],
        'profile' => [
            'label' => 'profile',
            'icon' => 'profile',
            'tooltip' => 'profile',
        ],
    ],
    'messages' => [
        'validation' => [
            'date' => [
                'required' => 'Le date sono obbligatorie',
                'date' => 'Le date devono essere valide',
                'after' => 'La data di fine deve essere successiva all\'inizio',
            ],
            'percentuale' => [
                'required' => 'La percentuale è obbligatoria',
                'numeric' => 'La percentuale deve essere numerica',
                'min' => 'La percentuale deve essere almeno :min',
                'max' => 'La percentuale non può superare :max',
            ],
            'importo' => [
                'required' => 'L\'importo è obbligatorio',
                'numeric' => 'L\'importo deve essere numerico',
                'min' => 'L\'importo deve essere maggiore di zero',
            ],
        ],
        'errors' => [
            'calculation_failed' => 'Calcolo della decurtazione fallito',
            'invalid_dates' => 'Date non valide',
            'already_processed' => 'Decurtazione già elaborata',
            'insufficient_permissions' => 'Permessi insufficienti',
        ],
        'warnings' => [
            'overlapping_dates' => 'Date sovrapposte con altre assenze',
            'high_deduction' => 'Decurtazione superiore alla media',
            'pending_approval' => 'In attesa di approvazione',
        ],
        'info' => [
            'calculation_details' => 'Dettagli del calcolo disponibili',
            'history_available' => 'Storico modifiche disponibile',
            'auto_calculation' => 'Calcolo automatico applicato',
        ],
    ],
    'label' => 'individuale decurtazione assenze',
];
