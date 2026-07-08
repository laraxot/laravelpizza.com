<?php

declare(strict_types=1);

return [
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'help' => 'Nome della performance',
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
            'help' => 'Nome del dipendente',
        ],
        'last_name' => [
            'label' => 'Cognome',
            'placeholder' => 'Inserisci il cognome',
            'help' => 'Cognome del dipendente',
        ],
        'select_all' => [
            'label' => 'Seleziona Tutti',
            'help' => 'Seleziona tutti gli elementi',
        ],
        'id' => [
            'label' => 'ID',
            'help' => 'Identificativo univoco',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'Inserisci l\'email',
            'help' => 'Indirizzo email del dipendente',
        ],
        'delete' => [
            'label' => 'Elimina',
        ],
        'toggleColumns' => [
            'label' => 'Mostra/Nascondi Colonne',
        ],
        'reorderRecords' => [
            'label' => 'Riordina Record',
        ],
        'resetFilters' => [
            'label' => 'Resetta Filtri',
        ],
        'applyFilters' => [
            'label' => 'Applica Filtri',
        ],
        'openFilters' => [
            'label' => 'openFilters',
        ],
    ],
    'actions' => [
        'import' => [
            'label' => 'Importa',
            'fields' => [
                'import_file' => [
                    'label' => 'Seleziona un file XLS o CSV da importare',
                    'placeholder' => 'Seleziona un file XLS o CSV',
                    'help' => 'Formati supportati: XLS, XLSX, CSV',
                ],
            ],
        ],
        'export' => [
            'label' => 'Esporta',
            'filename_prefix' => 'Performance_',
            'columns' => [
                'name' => [
                    'label' => 'Nome',
                    'help' => 'Nome della performance',
                ],
                'description' => [
                    'label' => 'Descrizione',
                    'help' => 'Descrizione della performance',
                ],
                'status' => [
                    'label' => 'Stato',
                    'help' => 'Stato della performance',
                ],
                'created_at' => [
                    'label' => 'Data Creazione',
                    'help' => 'Data di creazione della performance',
                ],
                'updated_at' => [
                    'label' => 'Ultimo Aggiornamento',
                    'help' => 'Data ultimo aggiornamento della performance',
                ],
            ],
        ],
        'copy_from_last_year_' => [
            'label' => 'copy_from_last_year_',
        ],
        'resetColumnManager' => [
            'tooltip' => 'resetColumnManager',
        ],
    ],
    'messages' => [
        'import' => [
            'success' => 'Importazione completata con successo',
            'error' => 'Errore durante l\'importazione',
        ],
        'export' => [
            'success' => 'Esportazione completata con successo',
            'error' => 'Errore durante l\'esportazione',
        ],
        'save' => [
            'success' => 'Performance salvata con successo',
            'error' => 'Errore durante il salvataggio',
        ],
        'delete' => [
            'success' => 'Performance eliminata con successo',
            'error' => 'Errore durante l\'eliminazione',
        ],
    ],
    'navigation' => [
        'name' => 'Performance',
        'plural' => 'Performance',
        'group' => [
            'name' => 'Valutazione & KPI',
            'description' => 'Gestione delle performance',
        ],
        'label' => 'Performance',
        'icon' => 'performance-chart',
        'sort' => 50,
    ],
    'model' => [
        'label' => 'performance.model',
    ],
];
