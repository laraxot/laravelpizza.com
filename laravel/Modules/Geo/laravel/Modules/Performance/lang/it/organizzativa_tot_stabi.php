<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Totale Stabilimenti',
        'plural' => 'Totali Stabilimenti',
        'group' => [
            'name' => 'Valutazione',
            'description' => 'Gestione dei totali per stabilimento',
        ],
        'label' => 'totali',
        'sort' => 85,
        'icon' => 'performance-building',
    ],
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'help' => 'Nome dello stabilimento',
        ],
        'totale' => [
            'label' => 'Totale',
            'placeholder' => 'Inserisci il totale',
            'help' => 'Totale performance dello stabilimento',
        ],
        'periodo' => [
            'label' => 'Periodo',
            'placeholder' => 'Seleziona il periodo',
            'help' => 'Periodo di riferimento',
        ],
        'guard_name' => [
            'label' => 'Sistema di Protezione',
            'placeholder' => 'Seleziona il sistema',
            'help' => 'Sistema di autenticazione utilizzato',
        ],
        'permissions' => [
            'label' => 'Autorizzazioni',
            'placeholder' => 'Seleziona le autorizzazioni',
            'help' => 'Autorizzazioni associate allo stabilimento',
        ],
        'updated_at' => [
            'label' => 'Ultimo aggiornamento',
            'help' => 'Data e ora dell\'ultima modifica',
        ],
        'first_name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'help' => 'Nome del responsabile',
        ],
        'last_name' => [
            'label' => 'Cognome',
            'placeholder' => 'Inserisci il cognome',
            'help' => 'Cognome del responsabile',
        ],
        'select_all' => [
            'label' => 'Seleziona Tutto',
            'message' => 'Seleziona tutti gli elementi disponibili',
        ],
        'dipendenti' => [
            'label' => 'Dipendenti',
            'placeholder' => 'Numero dipendenti',
            'help' => 'Numero totale dei dipendenti',
        ],
        'toggleColumns' => [
            'label' => 'toggleColumns',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
        ],
        'stabi' => [
            'label' => 'stabi',
        ],
        'tot_budget_assegnato' => [
            'label' => 'tot_budget_assegnato',
        ],
        'tot_budget_assegnato_min_punteggio' => [
            'label' => 'tot_budget_assegnato_min_punteggio',
        ],
        'tot_quota_effettiva' => [
            'label' => 'tot_quota_effettiva',
        ],
        'tot_quota_effettiva_min_punteggio' => [
            'label' => 'tot_quota_effettiva_min_punteggio',
        ],
        'tot_resti' => [
            'label' => 'tot_resti',
        ],
        'tot_resti_min_punteggio' => [
            'label' => 'tot_resti_min_punteggio',
        ],
        'delta' => [
            'label' => 'delta',
        ],
        'delta_min_punteggio' => [
            'label' => 'delta_min_punteggio',
        ],
        'anno' => [
            'label' => 'anno',
        ],
        'created_at' => [
            'label' => 'created_at',
        ],
        'value' => [
            'label' => 'value',
            'placeholder' => 'value',
            'helper_text' => 'value',
            'description' => 'value',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Nuovo Totale',
            'success' => 'Totale creato con successo',
            'icon' => 'create',
            'tooltip' => 'create',
        ],
        'edit' => [
            'label' => 'Modifica',
            'success' => 'Totale aggiornato con successo',
            'icon' => 'edit',
            'tooltip' => 'edit',
        ],
        'delete' => [
            'label' => 'Elimina',
            'success' => 'Totale eliminato con successo',
            'icon' => 'delete',
            'tooltip' => 'delete',
        ],
        'import' => [
            'label' => 'Importa',
            'fields' => [
                'import_file' => [
                    'label' => 'File da importare',
                    'placeholder' => 'Seleziona un file XLS o CSV',
                    'help' => 'Formati supportati: XLS, XLSX, CSV',
                ],
            ],
        ],
        'export' => [
            'label' => 'Esporta',
            'filename_prefix' => 'Totali_Stabilimenti_',
            'columns' => [
                'name' => [
                    'label' => 'Nome Stabilimento',
                    'help' => 'Nome dello stabilimento',
                ],
                'parent_name' => [
                    'label' => 'Area',
                    'help' => 'Area di appartenenza',
                ],
            ],
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
            'totale' => [
                'required' => 'Il totale è obbligatorio',
                'numeric' => 'Il totale deve essere numerico',
                'min' => 'Il totale deve essere maggiore di zero',
            ],
            'periodo' => [
                'required' => 'Il periodo è obbligatorio',
            ],
        ],
        'import' => [
            'success' => 'Importazione completata con successo',
            'error' => 'Errore durante l\'importazione',
        ],
        'export' => [
            'success' => 'Esportazione completata con successo',
            'error' => 'Errore durante l\'esportazione',
        ],
        'save' => [
            'success' => 'Totale salvato con successo',
            'error' => 'Errore durante il salvataggio',
        ],
        'delete' => [
            'success' => 'Totale eliminato con successo',
            'error' => 'Errore durante l\'eliminazione',
        ],
    ],
    'label' => 'organizzativa tot stabi',
];
