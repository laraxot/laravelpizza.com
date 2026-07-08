<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Assenze Organizzative',
        'plural' => 'Assenze Organizzative',
        'group' => [
            'name' => 'Valutazione',
            'description' => 'Gestione delle assenze organizzative',
        ],
        'label' => 'assenze',
        'sort' => 9,
        'icon' => 'performance-absence-outline',
    ],
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'help' => 'Nome dell\'assenza',
        ],
        'tipo_assenza' => [
            'label' => 'Tipo Assenza',
            'placeholder' => 'Seleziona il tipo',
            'help' => 'Tipo di assenza',
            'options' => [
                'malattia' => 'Malattia',
                'ferie' => 'Ferie',
                'permesso' => 'Permesso',
                'altro' => 'Altro',
            ],
        ],
        'data_inizio' => [
            'label' => 'Data Inizio',
            'placeholder' => 'Seleziona la data',
            'help' => 'Data di inizio assenza',
        ],
        'data_fine' => [
            'label' => 'Data Fine',
            'placeholder' => 'Seleziona la data',
            'help' => 'Data di fine assenza',
        ],
        'guard_name' => [
            'label' => 'Sistema di Protezione',
            'placeholder' => 'Seleziona il sistema',
            'help' => 'Sistema di autenticazione utilizzato',
        ],
        'permissions' => [
            'label' => 'Autorizzazioni',
            'placeholder' => 'Seleziona le autorizzazioni',
            'help' => 'Autorizzazioni associate all\'assenza',
        ],
        'updated_at' => [
            'label' => 'Ultimo aggiornamento',
            'help' => 'Data e ora dell\'ultima modifica',
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
            'label' => 'Seleziona Tutto',
            'message' => 'Seleziona tutti gli elementi disponibili',
        ],
        'note' => [
            'label' => 'Note',
            'placeholder' => 'Inserisci eventuali note',
            'help' => 'Note aggiuntive sull\'assenza',
        ],
        'tipo' => [
            'label' => 'tipo',
        ],
        'codice' => [
            'label' => 'codice',
        ],
        'descr' => [
            'label' => 'descr',
        ],
        'anno' => [
            'label' => 'anno',
        ],
        'created_at' => [
            'label' => 'created_at',
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
        'openFilters' => [
            'label' => 'openFilters',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
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
    ],
    'actions' => [
        'create' => [
            'label' => 'Nuova Assenza',
            'success' => 'Assenza creata con successo',
        ],
        'edit' => [
            'label' => 'Modifica',
            'success' => 'Assenza aggiornata con successo',
        ],
        'delete' => [
            'label' => 'Elimina',
            'success' => 'Assenza eliminata con successo',
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
            'filename_prefix' => 'Assenze_Organizzative_',
            'columns' => [
                'name' => [
                    'label' => 'Nome Assenza',
                    'help' => 'Nome dell\'assenza',
                ],
                'parent_name' => [
                    'label' => 'Reparto',
                    'help' => 'Reparto di appartenenza',
                ],
            ],
        ],
        'logout' => [
            'tooltip' => 'logout',
        ],
    ],
    'messages' => [
        'validation' => [
            'data_inizio' => [
                'required' => 'La data di inizio è obbligatoria',
                'date' => 'La data di inizio deve essere una data valida',
            ],
            'data_fine' => [
                'required' => 'La data di fine è obbligatoria',
                'date' => 'La data di fine deve essere una data valida',
                'after' => 'La data di fine deve essere successiva alla data di inizio',
            ],
            'tipo_assenza' => [
                'required' => 'Il tipo di assenza è obbligatorio',
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
            'success' => 'Assenza salvata con successo',
            'error' => 'Errore durante il salvataggio',
        ],
        'delete' => [
            'success' => 'Assenza eliminata con successo',
            'error' => 'Errore durante l\'eliminazione',
        ],
    ],
    'model' => [
        'label' => 'organizzativa assenze.model',
    ],
    'label' => 'organizzativa assenze',
];
