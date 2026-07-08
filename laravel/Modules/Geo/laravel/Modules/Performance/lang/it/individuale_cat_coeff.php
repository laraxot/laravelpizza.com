<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Coefficiente Categoria',
        'plural' => 'Coefficienti Categorie',
        'group' => [
            'name' => 'Valutazione',
            'description' => 'Gestione dei coefficienti per categoria',
        ],
        'label' => 'coefficienti',
        'sort' => 26,
        'icon' => 'performance-coefficient-outline',
    ],
    'fields' => [
        'categoria' => [
            'name' => [
                'label' => 'Nome Categoria',
                'placeholder' => 'Inserisci il nome della categoria',
                'help' => 'Nome identificativo della categoria',
            ],
            'codice' => [
                'label' => 'Codice',
                'placeholder' => 'Inserisci il codice categoria',
                'help' => 'Codice univoco della categoria',
            ],
            'descrizione' => [
                'label' => 'Descrizione',
                'placeholder' => 'Inserisci la descrizione',
                'help' => 'Descrizione dettagliata della categoria',
            ],
            'livello' => [
                'label' => 'Livello',
                'placeholder' => 'Seleziona il livello',
                'help' => 'Livello della categoria',
                'options' => [
                    'base' => 'Base',
                    'intermedio' => 'Intermedio',
                    'avanzato' => 'Avanzato',
                    'specialistico' => 'Specialistico',
                ],
            ],
        ],
        'coefficiente' => [
            'valore' => [
                'label' => 'Valore Coefficiente',
                'placeholder' => 'Inserisci il valore',
                'help' => 'Valore numerico del coefficiente',
            ],
            'minimo' => [
                'label' => 'Valore Minimo',
                'placeholder' => 'Inserisci il minimo',
                'help' => 'Valore minimo consentito',
            ],
            'massimo' => [
                'label' => 'Valore Massimo',
                'placeholder' => 'Inserisci il massimo',
                'help' => 'Valore massimo consentito',
            ],
            'step' => [
                'label' => 'Incremento',
                'placeholder' => 'Inserisci l\'incremento',
                'help' => 'Valore di incremento permesso',
            ],
        ],
        'applicazione' => [
            'data_inizio' => [
                'label' => 'Data Inizio',
                'placeholder' => 'Seleziona la data di inizio',
                'help' => 'Data di inizio validità',
            ],
            'data_fine' => [
                'label' => 'Data Fine',
                'placeholder' => 'Seleziona la data di fine',
                'help' => 'Data di fine validità',
            ],
            'stato' => [
                'label' => 'Stato',
                'help' => 'Stato attuale del coefficiente',
                'options' => [
                    'attivo' => 'Attivo',
                    'inattivo' => 'Inattivo',
                    'in_revisione' => 'In Revisione',
                    'scaduto' => 'Scaduto',
                ],
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
        'applyFilters' => [
            'label' => 'applyFilters',
        ],
        'toggleColumns' => [
            'label' => 'toggleColumns',
        ],
        'lista_propro' => [
            'label' => 'lista_propro',
        ],
        'coeff' => [
            'label' => 'coeff',
        ],
        'descr' => [
            'label' => 'descr',
        ],
        'tot_giorni' => [
            'label' => 'tot_giorni',
        ],
        'tot_giorni_pt' => [
            'label' => 'tot_giorni_pt',
        ],
        'tot_giorni_pt_coeff' => [
            'label' => 'tot_giorni_pt_coeff',
        ],
        'quota_teorica' => [
            'label' => 'quota_teorica',
        ],
        'anno' => [
            'label' => 'anno',
        ],
        'created_at' => [
            'label' => 'created_at',
        ],
        'updated_at' => [
            'label' => 'updated_at',
        ],
        'create' => [
            'label' => 'create',
        ],
        'edit' => [
            'label' => 'edit',
        ],
        'delete' => [
            'label' => 'delete',
        ],
        'value' => [
            'label' => 'value',
            'placeholder' => 'value',
            'helper_text' => 'value',
            'description' => 'value',
        ],
        'openFilters' => [
            'label' => 'openFilters',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Nuovo Coefficiente',
            'success' => 'Coefficiente creato con successo',
            'error' => 'Errore durante la creazione',
            'icon' => 'create',
            'tooltip' => 'create',
        ],
        'update' => [
            'label' => 'Modifica',
            'success' => 'Coefficiente aggiornato con successo',
            'error' => 'Errore durante l\'aggiornamento',
        ],
        'delete' => [
            'label' => 'Elimina',
            'success' => 'Coefficiente eliminato con successo',
            'error' => 'Errore durante l\'eliminazione',
            'confirm' => 'Sei sicuro di voler eliminare questo coefficiente?',
            'icon' => 'delete',
            'tooltip' => 'delete',
        ],
        'apply' => [
            'label' => 'Applica',
            'success' => 'Coefficiente applicato con successo',
            'error' => 'Errore durante l\'applicazione',
        ],
        'logout' => [
            'tooltip' => 'logout',
            'icon' => 'logout',
            'label' => 'logout',
        ],
        'reorderRecords' => [
            'tooltip' => 'reorderRecords',
            'label' => 'reorderRecords',
            'icon' => 'reorderRecords',
        ],
        'copy_from_last_year_' => [
            'label' => 'copy_from_last_year_',
            'icon' => 'copy_from_last_year_',
            'tooltip' => 'copy_from_last_year_',
        ],
        'edit' => [
            'label' => 'edit',
            'icon' => 'edit',
            'tooltip' => 'edit',
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
        'profile' => [
            'label' => 'profile',
            'icon' => 'profile',
            'tooltip' => 'profile',
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
    ],
    'messages' => [
        'validation' => [
            'valore' => [
                'required' => 'Il valore è obbligatorio',
                'numeric' => 'Il valore deve essere numerico',
                'between' => 'Il valore deve essere tra :min e :max',
            ],
            'categoria' => [
                'required' => 'La categoria è obbligatoria',
                'exists' => 'La categoria selezionata non esiste',
            ],
            'date' => [
                'required' => 'Le date sono obbligatorie',
                'date' => 'Le date devono essere valide',
                'after' => 'La data di fine deve essere successiva all\'inizio',
            ],
        ],
        'errors' => [
            'overlap_dates' => 'Date sovrapposte con altri coefficienti',
            'invalid_range' => 'Intervallo di valori non valido',
            'category_in_use' => 'Categoria già in uso nel periodo',
            'dependency_conflict' => 'Conflitto con altre configurazioni',
        ],
        'warnings' => [
            'value_unusual' => 'Valore insolito per la categoria',
            'expiring_soon' => 'Coefficiente in scadenza',
            'review_needed' => 'Necessaria revisione periodica',
        ],
        'info' => [
            'history_available' => 'Storico modifiche disponibile',
            'auto_calculation' => 'Calcolo automatico applicato',
            'category_stats' => 'Statistiche categoria disponibili',
        ],
    ],
    'model' => [
        'label' => 'individuale cat coeff.model',
    ],
    'label' => 'individuale cat coeff',
];
