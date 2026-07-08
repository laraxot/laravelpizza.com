<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Fondo Performance',
        'plural' => 'Fondi Performance',
        'group' => [
            'name' => 'Valutazione & KPI',
            'description' => 'Gestione dei fondi performance',
        ],
        'label' => 'Fondo Performance',
        'sort' => 54,
        'icon' => 'performance-fund-outline',
    ],
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'help' => 'Nome del fondo performance',
        ],
        'importo' => [
            'label' => 'Importo',
            'placeholder' => 'Inserisci l\'importo',
            'help' => 'Importo del fondo',
        ],
        'anno' => [
            'label' => 'Anno',
            'placeholder' => 'Seleziona l\'anno',
            'help' => 'Anno di riferimento',
            'description' => 'anno',
            'helper_text' => 'anno',
        ],
        'guard_name' => [
            'label' => 'Sistema di Protezione',
            'placeholder' => 'Seleziona il sistema',
            'help' => 'Sistema di autenticazione utilizzato',
        ],
        'permissions' => [
            'label' => 'Permessi',
            'placeholder' => 'Seleziona i permessi',
            'help' => 'Permessi associati al fondo',
        ],
        'updated_at' => [
            'label' => 'Aggiornato il',
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
        'stato' => [
            'label' => 'Stato',
            'placeholder' => 'Seleziona lo stato',
            'help' => 'Stato attuale del fondo',
            'options' => [
                'attivo' => 'Attivo',
                'chiuso' => 'Chiuso',
                'in_revisione' => 'In Revisione',
            ],
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
        'updated_by' => [
            'label' => 'updated_by',
        ],
        'created_by' => [
            'label' => 'created_by',
        ],
        'created_at' => [
            'label' => 'created_at',
        ],
        'delete' => [
            'label' => 'delete',
        ],
        'edit' => [
            'label' => 'edit',
        ],
        'view' => [
            'label' => 'view',
        ],
        'create' => [
            'label' => 'create',
        ],
        'note' => [
            'label' => 'note',
            'description' => 'note',
            'helper_text' => 'note',
            'placeholder' => 'note',
        ],
        'quota_organizzativa' => [
            'label' => 'quota_organizzativa',
            'description' => 'quota_organizzativa',
            'helper_text' => 'quota_organizzativa',
            'placeholder' => 'quota_organizzativa',
        ],
        'quota_individuale' => [
            'label' => 'quota_individuale',
            'description' => 'quota_individuale',
            'helper_text' => 'quota_individuale',
            'placeholder' => 'quota_individuale',
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
            'label' => 'Nuovo Fondo',
            'success' => 'Fondo creato con successo',
            'icon' => 'create',
            'tooltip' => 'create',
        ],
        'edit' => [
            'label' => 'Modifica',
            'success' => 'Fondo aggiornato con successo',
            'icon' => 'edit',
            'tooltip' => 'edit',
        ],
        'delete' => [
            'label' => 'Elimina',
            'success' => 'Fondo eliminato con successo',
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
            'filename_prefix' => 'Fondi_Performance_',
            'columns' => [
                'name' => [
                    'label' => 'Nome Fondo',
                    'help' => 'Nome del fondo performance',
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
        'organizzativa_spread_money' => [
            'label' => 'organizzativa_spread_money',
            'icon' => 'organizzativa_spread_money',
            'tooltip' => 'organizzativa_spread_money',
        ],
        'individuale_spread_money' => [
            'label' => 'individuale_spread_money',
            'icon' => 'individuale_spread_money',
            'tooltip' => 'individuale_spread_money',
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
        'removeAllFilters' => [
            'tooltip' => 'removeAllFilters',
            'icon' => 'removeAllFilters',
            'label' => 'removeAllFilters',
        ],
        'cancel' => [
            'tooltip' => 'cancel',
            'icon' => 'cancel',
            'label' => 'cancel',
        ],
        'save' => [
            'tooltip' => 'save',
            'label' => 'save',
            'icon' => 'save',
        ],
    ],
    'messages' => [
        'validation' => [
            'importo' => [
                'required' => 'L\'importo è obbligatorio',
                'numeric' => 'L\'importo deve essere numerico',
                'min' => 'L\'importo deve essere maggiore di zero',
            ],
            'anno' => [
                'required' => 'L\'anno è obbligatorio',
                'numeric' => 'L\'anno deve essere numerico',
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
            'success' => 'Fondo salvato con successo',
            'error' => 'Errore durante il salvataggio',
        ],
        'delete' => [
            'success' => 'Fondo eliminato con successo',
            'error' => 'Errore durante l\'eliminazione',
        ],
    ],
    'model' => [
        'label' => 'performance fondo.model',
    ],
    'pages' => [
        'organizzativa_money' => [
            'valutatore_check' => [
                'title' => [
                    'label' => 'Organizzativa senza valutatore',
                ],
                'description' => [
                    'label' => 'Righe con valutatore_id non valorizzato per anno :year e tipo :type.',
                ],
                'empty' => [
                    'label' => 'Nessuna riga: tutte le organizzative hanno valutatore_id valorizzato.',
                ],
                'row' => [
                    'label' => 'ID :id — matr :matr — :cognome :nome — stabi :stabi — repar :repar',
                ],
            ],
        ],
    ],
    'label' => 'performance fondo',
];
