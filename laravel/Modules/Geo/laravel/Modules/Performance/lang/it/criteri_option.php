<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Opzioni Criteri',
        'plural' => 'Opzioni Criteri',
        'group' => [
            'name' => 'Criteri',
            'description' => 'Gestione delle opzioni dei criteri',
        ],
        'label' => 'Opzioni Criteri',
        'sort' => 60,
        'icon' => 'performance-option-outline',
    ],
    'fields' => [
        'value_field' => [
            'label' => 'Valore',
        ],
        'anno_field' => [
            'label' => 'Anno',
        ],
        'created_by' => [
            'label' => 'Creato da',
        ],
        'field_name' => [
            'label' => 'Campo',
        ],
        'op' => [
            'label' => 'Operatore',
        ],
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'help' => 'Nome dell\'opzione',
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
            'help' => 'Data di ultimo aggiornamento',
        ],
        'first_name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'help' => 'Nome dell\'utente',
        ],
        'last_name' => [
            'label' => 'Cognome',
            'placeholder' => 'Inserisci il cognome',
            'help' => 'Cognome dell\'utente',
        ],
        'select_all' => [
            'label' => 'Seleziona Tutti',
            'help' => 'Seleziona tutte le opzioni',
        ],
        'valore' => [
            'label' => 'Valore',
            'placeholder' => 'Inserisci il valore',
            'help' => 'Valore dell\'opzione',
        ],
        'descrizione' => [
            'label' => 'Descrizione',
            'placeholder' => 'Inserisci la descrizione',
            'help' => 'Descrizione dettagliata dell\'opzione',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
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
        'openFilters' => [
            'label' => 'openFilters',
        ],
        'value' => [
            'label' => 'value',
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
        'anno' => [
            'label' => 'anno',
        ],
    ],
    'actions' => [
        'import' => [
            'fields' => [
                'import_file' => [
                    'label' => 'File da importare',
                    'placeholder' => 'Seleziona un file XLS o CSV',
                    'help' => 'Seleziona il file da importare (formati supportati: XLS, CSV)',
                ],
            ],
        ],
        'export' => [
            'filename_prefix' => 'Criteri_Opzioni_',
            'columns' => [
                'name' => [
                    'label' => 'Nome',
                    'help' => 'Nome dell\'opzione',
                ],
                'valore' => [
                    'label' => 'Valore',
                    'help' => 'Valore dell\'opzione',
                ],
            ],
        ],
        'create' => [
            'label' => 'create',
        ],
        'logout' => [
            'tooltip' => 'logout',
        ],
    ],
    'model' => [
        'label' => 'criteri option.model',
    ],
];
