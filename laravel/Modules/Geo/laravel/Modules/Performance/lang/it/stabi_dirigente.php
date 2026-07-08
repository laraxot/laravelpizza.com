<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Performance Dirigenziale',
        'plural' => 'Performance Dirigenziali',
        'group' => [
            'name' => 'Valutazione & KPI',
            'description' => 'Gestione delle performance dei dirigenti',
        ],
        'label' => 'Performance Dirigenziale',
        'sort' => 58,
        'icon' => 'performance-manager',
    ],
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'help' => 'Nome della performance dirigenziale',
        ],
        'dirigente' => [
            'label' => 'Dirigente',
            'placeholder' => 'Seleziona il dirigente',
            'help' => 'Dirigente di riferimento',
        ],
        'struttura' => [
            'label' => 'Struttura',
            'placeholder' => 'Seleziona la struttura',
            'help' => 'Struttura organizzativa',
        ],
        'anno' => [
            'label' => 'Anno',
            'placeholder' => 'Seleziona l\'anno',
            'help' => 'Anno di riferimento',
            'description' => 'anno',
            'helper_text' => 'anno',
        ],
        'punteggio' => [
            'label' => 'Punteggio',
            'placeholder' => 'Inserisci il punteggio',
            'help' => 'Punteggio della performance',
        ],
        'guard_name' => [
            'label' => 'Sistema di Protezione',
            'placeholder' => 'Seleziona il sistema',
            'help' => 'Sistema di protezione utilizzato',
        ],
        'permissions' => [
            'label' => 'Permessi',
            'placeholder' => 'Seleziona i permessi',
            'help' => 'Permessi associati',
        ],
        'updated_at' => [
            'label' => 'Aggiornato il',
            'help' => 'Data ultimo aggiornamento',
        ],
        'first_name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'help' => 'Nome del dirigente',
        ],
        'last_name' => [
            'label' => 'Cognome',
            'placeholder' => 'Inserisci il cognome',
            'help' => 'Cognome del dirigente',
        ],
        'select_all' => [
            'label' => 'Seleziona Tutto',
            'message' => 'Seleziona tutti gli elementi disponibili',
        ],
        'stabilimento' => [
            'label' => 'Stabilimento',
            'placeholder' => 'Seleziona lo stabilimento',
            'help' => 'Stabilimento di riferimento',
        ],
        'ruolo' => [
            'label' => 'Ruolo',
            'placeholder' => 'Seleziona il ruolo',
            'help' => 'Ruolo del dirigente nello stabilimento',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
        ],
        'id' => [
            'label' => 'id',
            'placeholder' => 'id',
            'helper_text' => 'id',
            'description' => 'id',
        ],
        'valutatore_id' => [
            'label' => 'valutatore_id',
            'placeholder' => 'valutatore_id',
            'helper_text' => 'valutatore_id',
            'description' => 'valutatore_id',
        ],
        'stabi' => [
            'label' => 'stabi',
            'placeholder' => 'stabi',
            'helper_text' => 'stabi',
            'description' => 'stabi',
        ],
        'repar' => [
            'label' => 'repar',
            'placeholder' => 'repar',
            'helper_text' => 'repar',
            'description' => 'repar',
        ],
        'nome_stabi' => [
            'label' => 'nome_stabi',
            'placeholder' => 'nome_stabi',
            'helper_text' => 'nome_stabi',
            'description' => 'nome_stabi',
        ],
        'matr' => [
            'label' => 'matr',
            'placeholder' => 'matr',
            'helper_text' => 'matr',
            'description' => 'matr',
        ],
        'nome_diri' => [
            'label' => 'nome_diri',
            'placeholder' => 'nome_diri',
            'helper_text' => 'nome_diri',
            'description' => 'nome_diri',
        ],
        'nome_diri_plus' => [
            'label' => 'nome_diri_plus',
            'placeholder' => 'nome_diri_plus',
            'helper_text' => 'nome_diri_plus',
            'description' => 'nome_diri_plus',
        ],
        'email' => [
            'label' => 'email',
            'placeholder' => 'email',
            'helper_text' => 'email',
            'description' => 'email',
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
        'toggleColumns' => [
            'label' => 'toggleColumns',
        ],
        'file' => [
            'label' => 'file',
        ],
        'header_row' => [
            'label' => 'header_row',
        ],
        'rep' => [
            'label' => 'rep',
        ],
        'diri' => [
            'label' => 'diri',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Nuovo Dirigente',
            'success' => 'Dirigente creato con successo',
            'icon' => 'create',
            'tooltip' => 'create',
        ],
        'edit' => [
            'label' => 'Modifica',
            'success' => 'Dirigente aggiornato con successo',
            'icon' => 'edit',
            'tooltip' => 'edit',
        ],
        'delete' => [
            'label' => 'Elimina',
            'success' => 'Dirigente eliminato con successo',
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
            'filename_prefix' => 'Stabilimenti_Dirigenti_',
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
        'importXLS' => [
            'label' => 'importXLS',
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
        'import_valutatori' => [
            'tooltip' => 'import_valutatori',
            'icon' => 'import_valutatori',
            'label' => 'import_valutatori',
        ],
        'submit' => [
            'label' => 'submit',
            'icon' => 'submit',
            'tooltip' => 'submit',
        ],
        'cancel' => [
            'label' => 'cancel',
            'icon' => 'cancel',
            'tooltip' => 'cancel',
        ],
        'save' => [
            'tooltip' => 'save',
            'label' => 'save',
            'icon' => 'save',
        ],
        'stabi' => [
            'label' => 'stabi',
            'icon' => 'stabi',
            'tooltip' => 'stabi',
        ],
        'repar' => [
            'label' => 'repar',
            'icon' => 'repar',
            'tooltip' => 'repar',
        ],
        'nome_stabi' => [
            'label' => 'nome_stabi',
            'icon' => 'nome_stabi',
            'tooltip' => 'nome_stabi',
        ],
    ],
    'messages' => [
        'validation' => [
            'stabilimento' => [
                'required' => 'Lo stabilimento è obbligatorio',
            ],
            'ruolo' => [
                'required' => 'Il ruolo è obbligatorio',
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
            'success' => 'Dirigente salvato con successo',
            'error' => 'Errore durante il salvataggio',
        ],
        'delete' => [
            'success' => 'Dirigente eliminato con successo',
            'error' => 'Errore durante l\'eliminazione',
        ],
    ],
    'model' => [
        'label' => 'stabi dirigente.model',
    ],
    'label' => 'stabi dirigente',
];
