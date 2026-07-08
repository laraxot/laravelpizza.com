<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Criterio di Esclusione',
        'plural' => 'Criteri di Esclusione',
        'group' => [
            'name' => 'Gestione Progressioni',
            'description' => 'Gestione completa delle progressioni di carriera',
        ],
        'sort' => 11,
        'icon' => 'heroicon-o-x-circle',
        'label' => 'Criteri di Esclusione',
    ],
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome del criterio',
            'help' => 'Nome identificativo del criterio di esclusione',
        ],
        'parent' => [
            'label' => 'Padre',
            'placeholder' => 'Seleziona l\'elemento padre',
            'help' => 'Elemento di livello superiore',
        ],
        'parent_name' => [
            'label' => 'Nome Padre',
            'placeholder' => 'Nome dell\'elemento padre',
            'help' => 'Nome dell\'elemento di livello superiore',
        ],
        'assets' => [
            'label' => 'Risorse',
            'placeholder' => 'Seleziona le risorse associate',
            'help' => 'Risorse collegate a questo criterio',
        ],
        'toggleColumns' => [
            'label' => 'Mostra/Nascondi Colonne',
            'help' => 'Gestisci la visibilità delle colonne nella tabella',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
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
            'description' => 'value',
            'helper_text' => 'value',
            'placeholder' => 'value',
            'label' => 'value',
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
        'check' => [
            'label' => 'check',
        ],
        'anno' => [
            'label' => 'anno',
            'description' => 'anno',
            'helper_text' => 'anno',
            'placeholder' => 'anno',
        ],
        'layout' => [
            'label' => 'layout',
        ],
        'create' => [
            'label' => 'create',
        ],
        'type' => [
            'label' => 'type',
        ],
        'op' => [
            'label' => 'op',
        ],
        'field_name' => [
            'label' => 'field_name',
        ],
        'id' => [
            'label' => 'id',
        ],
        'updated_at' => [
            'description' => 'updated_at',
            'helper_text' => 'updated_at',
            'placeholder' => 'updated_at',
            'label' => 'updated_at',
        ],
        'created_at' => [
            'description' => 'created_at',
            'helper_text' => 'created_at',
            'placeholder' => 'created_at',
            'label' => 'created_at',
        ],
        'is_enabled' => [
            'label' => 'is_enabled',
        ],
    ],
    'actions' => [
        'import' => [
            'label' => 'Importa da file',
            'success' => 'File importato con successo',
            'error' => 'Errore durante l\'importazione del file',
            'confirmation' => 'Sei sicuro di voler importare questo file?',
            'fields' => [
                'import_file' => [
                    'label' => 'File da importare',
                    'placeholder' => 'Seleziona un file XLS o CSV da caricare',
                    'help' => 'Formati supportati: XLS, XLSX, CSV. Dimensione massima: 10MB',
                ],
            ],
        ],
        'export' => [
            'label' => 'Esporta dati',
            'success' => 'Dati esportati con successo',
            'error' => 'Errore durante l\'esportazione',
            'confirmation' => 'Sei sicuro di voler esportare i dati?',
            'filename_prefix' => 'Criteri_Esclusione_',
            'columns' => [
                'name' => [
                    'label' => 'Nome criterio',
                    'help' => 'Nome del criterio di esclusione',
                ],
                'parent_name' => [
                    'label' => 'Nome elemento padre',
                    'help' => 'Nome dell\'elemento di livello superiore',
                ],
            ],
        ],
        'create' => [
            'label' => 'Nuovo criterio',
            'success' => 'Criterio di esclusione creato con successo',
            'error' => 'Errore durante la creazione del criterio',
            'icon' => 'create',
            'tooltip' => 'create',
        ],
        'edit' => [
            'label' => 'Modifica criterio',
            'success' => 'Criterio di esclusione aggiornato con successo',
            'error' => 'Errore durante l\'aggiornamento del criterio',
            'icon' => 'edit',
            'tooltip' => 'edit',
        ],
        'delete' => [
            'label' => 'Elimina criterio',
            'success' => 'Criterio di esclusione eliminato con successo',
            'error' => 'Errore durante l\'eliminazione del criterio',
            'confirmation' => 'Sei sicuro di voler eliminare questo criterio? Questa azione è irreversibile.',
            'icon' => 'delete',
            'tooltip' => 'delete',
        ],
        'view' => [
            'label' => 'Visualizza criterio',
            'icon' => 'view',
            'tooltip' => 'view',
        ],
        'copy_from_last_year' => [
            'label' => 'copy_from_last_year',
        ],
        'copy_from_last_year_' => [
            'label' => 'copy_from_last_year_',
            'icon' => 'copy_from_last_year_',
            'tooltip' => 'copy_from_last_year_',
        ],
        'logout' => [
            'tooltip' => 'logout',
            'icon' => 'logout',
            'label' => 'logout',
        ],
        'profile' => [
            'tooltip' => 'profile',
            'icon' => 'profile',
            'label' => 'profile',
        ],
        'removeAllFilters' => [
            'tooltip' => 'removeAllFilters',
            'label' => 'removeAllFilters',
            'icon' => 'removeAllFilters',
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
        'save' => [
            'label' => 'save',
            'icon' => 'save',
            'tooltip' => 'save',
        ],
        'cancel' => [
            'label' => 'cancel',
            'icon' => 'cancel',
            'tooltip' => 'cancel',
        ],
        'submit' => [
            'label' => 'submit',
            'icon' => 'submit',
            'tooltip' => 'submit',
        ],
    ],
    'tabs' => [
        'index' => [
            'label' => 'Lista',
            'description' => 'Visualizza tutti i criteri di esclusione',
        ],
        'create' => [
            'label' => 'Aggiungi',
            'description' => 'Crea un nuovo criterio di esclusione',
        ],
        'edit' => [
            'label' => 'Modifica',
            'description' => 'Modifica il criterio di esclusione selezionato',
        ],
    ],
    'messages' => [
        'created' => 'Criterio di esclusione creato con successo',
        'updated' => 'Criterio di esclusione aggiornato con successo',
        'deleted' => 'Criterio di esclusione eliminato con successo',
        'import_success' => 'Importazione completata con successo',
        'export_success' => 'Esportazione completata con successo',
        'error' => 'Si è verificato un errore',
        'warning' => 'Attenzione',
        'info' => 'Informazione',
    ],
    'validation' => [
        'required' => 'Il campo :attribute è obbligatorio',
        'string' => 'Il campo :attribute deve essere una stringa',
        'max' => 'Il campo :attribute non può superare :max caratteri',
        'unique' => 'Il valore del campo :attribute è già presente',
    ],
    'model' => [
        'label' => 'Modello Criteri Esclusione',
        'placeholder' => 'Seleziona modello criteri',
        'tooltip' => 'Modello dati per i criteri di esclusione',
        'helper_text' => 'Rappresentazione del modello dati utilizzato per definire i criteri di esclusione dalle progressioni',
        'help' => 'Modello che definisce la struttura dati per i criteri di esclusione',
    ],
    'label' => 'criteri esclusione',
];
