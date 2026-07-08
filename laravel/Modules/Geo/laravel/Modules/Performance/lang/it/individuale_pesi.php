<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Peso Performance',
        'plural' => 'Pesi Performance',
        'group' => [
            'name' => 'Valutazione',
            'description' => 'Gestione dei pesi per il calcolo delle performance',
        ],
        'label' => 'pesi',
        'sort' => 96,
        'icon' => 'performance-weight',
    ],
    'fields' => [
        'categoria' => [
            'name' => [
                'label' => 'Nome Categoria',
                'placeholder' => 'Inserisci il nome della categoria',
                'help' => 'Nome identificativo della categoria di peso',
            ],
            'descrizione' => [
                'label' => 'Descrizione',
                'placeholder' => 'Inserisci la descrizione',
                'help' => 'Descrizione dettagliata della categoria',
            ],
            'tipo' => [
                'label' => 'Tipo Categoria',
                'placeholder' => 'Seleziona il tipo',
                'help' => 'Tipologia della categoria di peso',
                'options' => [
                    'obiettivi' => 'Obiettivi',
                    'competenze' => 'Competenze',
                    'comportamenti' => 'Comportamenti',
                    'risultati' => 'Risultati',
                ],
            ],
        ],
        'peso' => [
            'valore' => [
                'label' => 'Valore Peso',
                'placeholder' => 'Inserisci il valore (0-100)',
                'help' => 'Valore percentuale del peso',
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
        ],
        'applicazione' => [
            'livello' => [
                'label' => 'Livello',
                'placeholder' => 'Seleziona il livello',
                'help' => 'Livello di applicazione del peso',
                'options' => [
                    'globale' => 'Globale',
                    'regionale' => 'Regionale',
                    'locale' => 'Locale',
                ],
            ],
            'periodo' => [
                'label' => 'Periodo',
                'placeholder' => 'Seleziona il periodo',
                'help' => 'Periodo di validità del peso',
            ],
            'stato' => [
                'label' => 'Stato',
                'help' => 'Stato attuale del peso',
                'options' => [
                    'attivo' => 'Attivo',
                    'inattivo' => 'Inattivo',
                    'bozza' => 'Bozza',
                ],
            ],
        ],
        'timestamps' => [
            'created_at' => [
                'label' => 'Data Creazione',
                'help' => 'Data di creazione del peso',
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
        'type' => [
            'label' => 'type',
        ],
        'lista_propro' => [
            'label' => 'lista_propro',
        ],
        'descr' => [
            'label' => 'descr',
        ],
        'peso_esperienza_acquisita' => [
            'label' => 'peso_esperienza_acquisita',
        ],
        'peso_risultati_ottenuti' => [
            'label' => 'peso_risultati_ottenuti',
        ],
        'peso_arricchimento_professionale' => [
            'label' => 'peso_arricchimento_professionale',
        ],
        'peso_impegno' => [
            'label' => 'peso_impegno',
        ],
        'peso_qualita_prestazione' => [
            'label' => 'peso_qualita_prestazione',
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
        'created_by' => [
            'label' => 'created_by',
        ],
        'updated_by' => [
            'label' => 'updated_by',
        ],
        'pesi_non_zero' => [
            'label' => 'pesi_non_zero',
        ],
        'value' => [
            'label' => 'Cerca nella Lista ProPro',
            'placeholder' => 'Inserisci il testo da cercare',
            'helper_text' => 'value',
            'description' => 'value',
        ],
        'create' => [
            'label' => 'create',
        ],
        'view' => [
            'label' => 'view',
        ],
        'edit' => [
            'label' => 'edit',
        ],
        'delete' => [
            'label' => 'delete',
        ],
        'isActive' => [
            'label' => 'isActive',
            'placeholder' => 'isActive',
            'helper_text' => 'isActive',
            'description' => 'isActive',
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
            'label' => 'Nuovo Peso',
            'success' => 'Peso creato con successo',
            'error' => 'Errore durante la creazione del peso',
            'icon' => 'create',
            'tooltip' => 'create',
        ],
        'update' => [
            'label' => 'Modifica',
            'success' => 'Peso aggiornato con successo',
            'error' => 'Errore durante l\'aggiornamento',
        ],
        'delete' => [
            'label' => 'Elimina',
            'success' => 'Peso eliminato con successo',
            'error' => 'Errore durante l\'eliminazione',
            'confirm' => 'Sei sicuro di voler eliminare questo peso?',
            'icon' => 'delete',
            'tooltip' => 'delete',
        ],
        'distribute' => [
            'label' => 'Distribuisci',
            'success' => 'Pesi distribuiti con successo',
            'error' => 'Errore durante la distribuzione',
        ],
        'logout' => [
            'tooltip' => 'logout',
            'label' => 'logout',
            'icon' => 'logout',
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
            'valore' => [
                'required' => 'Il valore è obbligatorio',
                'numeric' => 'Il valore deve essere numerico',
                'min' => 'Il valore deve essere almeno :min',
                'max' => 'Il valore non può superare :max',
            ],
            'categoria' => [
                'required' => 'La categoria è obbligatoria',
                'exists' => 'La categoria selezionata non esiste',
            ],
            'periodo' => [
                'required' => 'Il periodo è obbligatorio',
                'date' => 'Il periodo deve essere una data valida',
            ],
        ],
        'errors' => [
            'total_exceeded' => 'Il totale dei pesi supera il 100%',
            'invalid_distribution' => 'Distribuzione dei pesi non valida',
            'overlap_period' => 'Periodo si sovrappone con altri pesi',
            'dependency_conflict' => 'Conflitto con pesi dipendenti',
        ],
        'warnings' => [
            'unbalanced' => 'Distribuzione dei pesi sbilanciata',
            'unused_categories' => 'Categorie senza pesi assegnati',
            'expiring_soon' => 'Alcuni pesi stanno per scadere',
        ],
        'info' => [
            'distribution_ready' => 'Distribuzione pronta per l\'applicazione',
            'balanced' => 'Pesi distribuiti in modo equilibrato',
            'history_available' => 'Storico modifiche disponibile',
        ],
    ],
    'model' => [
        'label' => 'individuale pesi.model',
    ],
    'label' => 'individuale pesi',
];
