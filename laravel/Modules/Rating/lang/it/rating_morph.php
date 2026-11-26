<?php

declare(strict_types=1);

return [
    'pages' => 'Pagine',
    'widgets' => 'Widget',
    'navigation' => [
        'name' => 'Rating Pivot',
        'plural' => 'Rating Pivot',
        'group' => [
            'name' => 'Gestione Rating',
        ],
        'label' => 'Rating Morph',
        'sort' => 6,
        'icon' => 'heroicon-o-star',
    ],
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'help_text' => 'Nome univoco dell\'elemento',
        ],
        'guard_name' => [
            'label' => 'Guard',
            'placeholder' => 'Seleziona la guardia',
            'help_text' => 'Definisce il contesto di sicurezza',
        ],
        'permissions' => [
            'label' => 'Permessi',
            'placeholder' => 'Seleziona i permessi',
            'help_text' => 'Permessi associati all\'elemento',
        ],
        'updated_at' => [
            'label' => 'Aggiornato il',
            'help_text' => 'Data e ora dell\'ultimo aggiornamento',
        ],
        'first_name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
        ],
        'last_name' => [
            'label' => 'Cognome',
            'placeholder' => 'Inserisci il cognome',
        ],
        'select_all' => [
            'label' => 'Seleziona Tutti',
            'message' => 'Seleziona tutti gli elementi disponibili',
        ],
        'id' => [
            'label' => 'ID',
        ],
        'rating_id' => [
            'label' => 'ID criterio',
        ],
        'model_type' => [
            'label' => 'Tipo elemento valutato',
        ],
        'model_id' => [
            'label' => 'ID elemento valutato',
        ],
        'user_id' => [
            'label' => 'ID utente',
        ],
        'value' => [
            'label' => 'Voto',
        ],
        'note' => [
            'label' => 'Nota',
        ],
        'is_winner' => [
            'label' => 'Vincente',
        ],
        'reward' => [
            'label' => 'Premio',
        ],
        'created_at' => [
            'label' => 'Creato il',
        ],
        'rating' => [
            'label' => 'Criterio',
        ],
        'ratingable_type' => [
            'label' => 'Tipo elemento valutato',
        ],
        'ratingable_id' => [
            'label' => 'ID elemento valutato',
        ],
    ],
    'actions' => [
        'import' => [
            'label' => 'Importa',
            'description' => 'Carica un file per importare dati',
            'fields' => [
                'import_file' => [
                    'label' => 'File da importare',
                    'placeholder' => 'Seleziona un file XLS o CSV',
                    'help_text' => 'Deve essere un file valido in formato CSV o Excel',
                ],
            ],
            'messages' => [
                'success' => 'Importazione completata con successo',
                'error' => 'Errore durante l\'importazione',
            ],
        ],
        'export' => [
            'label' => 'Esporta',
            'description' => 'Esporta i dati in un file',
            'filename_prefix' => 'Aree al',
            'columns' => [
                'name' => [
                    'label' => 'Nome area',
                ],
                'parent_name' => [
                    'label' => 'Nome area livello superiore',
                ],
            ],
            'messages' => [
                'success' => 'Esportazione completata con successo',
                'error' => 'Errore durante l\'esportazione',
            ],
        ],
        'delete' => [
            'label' => 'Elimina',
            'confirmation' => 'Sei sicuro di voler eliminare questo elemento?',
            'messages' => [
                'success' => 'Elemento eliminato con successo',
                'error' => 'Errore durante l\'eliminazione',
            ],
            'icon' => 'delete',
            'tooltip' => 'delete',
        ],
        'edit' => [
            'label' => 'Modifica',
            'description' => 'Modifica i dettagli dell\'elemento',
            'messages' => [
                'success' => 'Modifica salvata con successo',
                'error' => 'Errore durante il salvataggio',
            ],
            'icon' => 'edit',
            'tooltip' => 'edit',
        ],
        'create' => [
            'label' => 'Nuovo voto',
            'description' => 'Aggiungi un nuovo elemento',
            'messages' => [
                'success' => 'Elemento creato con successo',
                'error' => 'Errore durante la creazione',
            ],
            'icon' => 'create',
            'tooltip' => 'create',
        ],
        'logout' => [
            'tooltip' => 'logout',
            'icon' => 'logout',
            'label' => 'logout',
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
        'profile' => [
            'label' => 'profile',
        ],
        'cancel' => [
            'label' => 'cancel',
        ],
        'createAnother' => [
            'label' => 'createAnother',
        ],
    ],
    'label' => 'rating morph',
];
