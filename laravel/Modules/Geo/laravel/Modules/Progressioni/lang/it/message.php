<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Messaggio',
        'plural' => 'Messaggi',
        'group' => [
            'name' => 'Gestione Progressioni',
            'description' => 'Gestione completa delle progressioni di carriera',
        ],
        'sort' => 14,
        'icon' => 'heroicon-o-chat-bubble-left-right',
        'label' => 'Messaggi',
    ],
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome del messaggio',
            'help' => 'Nome identificativo del messaggio',
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
            'help' => 'Risorse collegate a questo messaggio',
        ],
        'toggleColumns' => [
            'label' => 'Mostra/Nascondi Colonne',
            'help' => 'Gestisci la visibilità delle colonne nella tabella',
        ],
        'reorderRecords' => [
            'label' => 'Riordina Record',
            'help' => 'Riordina i record nella tabella',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
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
        'updated_at' => [
            'description' => 'updated_at',
            'helper_text' => 'updated_at',
            'placeholder' => 'updated_at',
            'label' => 'updated_at',
        ],
        'anno' => [
            'description' => 'anno',
            'helper_text' => 'anno',
            'label' => 'anno',
        ],
        'id' => [
            'label' => 'id',
        ],
        'type' => [
            'label' => 'type',
        ],
        'title' => [
            'label' => 'title',
        ],
        'txt' => [
            'label' => 'txt',
        ],
        'created_at' => [
            'label' => 'created_at',
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
            'filename_prefix' => 'Messaggi_',
            'columns' => [
                'name' => [
                    'label' => 'Nome messaggio',
                    'help' => 'Nome del messaggio',
                ],
                'parent_name' => [
                    'label' => 'Nome elemento padre',
                    'help' => 'Nome dell\'elemento di livello superiore',
                ],
            ],
        ],
        'create' => [
            'label' => 'Nuovo messaggio',
            'success' => 'Messaggio creato con successo',
            'error' => 'Errore durante la creazione del messaggio',
            'tooltip' => 'create',
            'icon' => 'create',
        ],
        'edit' => [
            'label' => 'Modifica messaggio',
            'success' => 'Messaggio aggiornato con successo',
            'error' => 'Errore durante l\'aggiornamento del messaggio',
            'tooltip' => 'edit',
            'icon' => 'edit',
        ],
        'delete' => [
            'label' => 'Elimina messaggio',
            'success' => 'Messaggio eliminato con successo',
            'error' => 'Errore durante l\'eliminazione del messaggio',
            'confirmation' => 'Sei sicuro di voler eliminare questo messaggio? Questa azione è irreversibile.',
            'tooltip' => 'delete',
            'icon' => 'delete',
        ],
        'view' => [
            'label' => 'Visualizza messaggio',
            'tooltip' => 'view',
            'icon' => 'view',
        ],
        'logout' => [
            'tooltip' => 'logout',
            'icon' => 'logout',
            'label' => 'logout',
        ],
        'cancel' => [
            'tooltip' => 'cancel',
            'icon' => 'cancel',
            'label' => 'cancel',
        ],
        'profile' => [
            'tooltip' => 'profile',
            'icon' => 'profile',
            'label' => 'profile',
        ],
        'reorderRecords' => [
            'tooltip' => 'reorderRecords',
            'icon' => 'reorderRecords',
            'label' => 'reorderRecords',
        ],
        'save' => [
            'tooltip' => 'save',
            'icon' => 'save',
            'label' => 'save',
        ],
        'openColumnManager' => [
            'tooltip' => 'openColumnManager',
            'icon' => 'openColumnManager',
            'label' => 'openColumnManager',
        ],
        'createOption' => [
            'tooltip' => 'createOption',
            'icon' => 'createOption',
            'label' => 'createOption',
        ],
        'submit' => [
            'tooltip' => 'submit',
            'icon' => 'submit',
        ],
        'applyTableColumnManager' => [
            'tooltip' => 'applyTableColumnManager',
            'icon' => 'applyTableColumnManager',
            'label' => 'applyTableColumnManager',
        ],
        'resetFilters' => [
            'tooltip' => 'resetFilters',
            'icon' => 'resetFilters',
            'label' => 'resetFilters',
        ],
        'applyFilters' => [
            'tooltip' => 'applyFilters',
            'icon' => 'applyFilters',
            'label' => 'applyFilters',
        ],
        'openFilters' => [
            'tooltip' => 'openFilters',
            'icon' => 'openFilters',
            'label' => 'openFilters',
        ],
        'CheckCriterioEsclusioneBulkAction' => [
            'tooltip' => 'CheckCriterioEsclusioneBulkAction',
            'icon' => 'CheckCriterioEsclusioneBulkAction',
            'label' => 'CheckCriterioEsclusioneBulkAction',
        ],
        'check' => [
            'tooltip' => 'check',
            'icon' => 'check',
            'label' => 'check',
        ],
        'layout' => [
            'tooltip' => 'layout',
            'icon' => 'layout',
            'label' => 'layout',
        ],
        'resetColumnManager' => [
            'tooltip' => 'resetColumnManager',
            'label' => 'resetColumnManager',
            'icon' => 'resetColumnManager',
        ],
        'copy_from_last_year' => [
            'label' => 'copy_from_last_year',
            'icon' => 'copy_from_last_year',
            'tooltip' => 'copy_from_last_year',
        ],
        'removeAllFilters' => [
            'label' => 'removeAllFilters',
            'icon' => 'removeAllFilters',
            'tooltip' => 'removeAllFilters',
        ],
    ],
    'tabs' => [
        'index' => [
            'label' => 'Lista',
            'description' => 'Visualizza tutti i messaggi',
        ],
        'create' => [
            'label' => 'Aggiungi',
            'description' => 'Crea un nuovo messaggio',
        ],
    ],
    'model' => [
        'label' => 'Messaggio',
        'plural' => 'Messaggi',
        'description' => 'Gestione messaggi del sistema',
    ],
    'messages' => [
        'created' => 'Messaggio creato con successo',
        'updated' => 'Messaggio aggiornato con successo',
        'deleted' => 'Messaggio eliminato con successo',
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
    'label' => 'message',
];
