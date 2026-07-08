<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Criterio di Precedenza',
        'plural' => 'Criteri di Precedenza',
        'group' => [
            'name' => 'Gestione Progressioni',
            'description' => 'Gestione completa delle progressioni di carriera',
        ],
        'sort' => 5,
        'icon' => 'heroicon-o-list-bullet',
        'label' => 'Criteri di Precedenza',
    ],
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome del criterio di precedenza',
            'help' => 'Nome identificativo del criterio di precedenza',
        ],
        'parent' => [
            'label' => 'Elemento Padre',
            'placeholder' => 'Seleziona l\'elemento padre',
            'help' => 'Elemento di livello superiore nella gerarchia',
        ],
        'parent_name' => [
            'label' => 'Nome Elemento Padre',
            'placeholder' => 'Nome dell\'elemento padre',
            'help' => 'Nome dell\'elemento di livello superiore',
        ],
        'assets' => [
            'label' => 'Risorse',
            'placeholder' => 'Seleziona le risorse associate',
            'help' => 'Risorse collegate a questo criterio di precedenza',
        ],
        'toggleColumns' => [
            'label' => 'toggleColumns',
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
        'id' => [
            'label' => 'id',
        ],
        'parent_id' => [
            'label' => 'parent_id',
        ],
        'order_direction' => [
            'label' => 'order_direction',
        ],
        'label' => [
            'label' => 'label',
        ],
        'descr' => [
            'label' => 'descr',
        ],
        'post_type' => [
            'label' => 'post_type',
        ],
        'posizione' => [
            'label' => 'posizione',
        ],
        'anno' => [
            'label' => 'anno',
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
            'filename_prefix' => 'Criteri_Precedenza_',
            'columns' => [
                'name' => [
                    'label' => 'Nome criterio di precedenza',
                    'help' => 'Nome del criterio di precedenza',
                ],
                'parent_name' => [
                    'label' => 'Nome elemento padre',
                    'help' => 'Nome dell\'elemento di livello superiore',
                ],
            ],
        ],
        'create' => [
            'label' => 'Nuovo criterio',
            'success' => 'Criterio di precedenza creato con successo',
            'error' => 'Errore durante la creazione del criterio',
            'icon' => 'create',
            'tooltip' => 'create',
        ],
        'edit' => [
            'label' => 'Modifica criterio',
            'success' => 'Criterio di precedenza aggiornato con successo',
            'error' => 'Errore durante l\'aggiornamento del criterio',
            'icon' => 'edit',
            'tooltip' => 'edit',
        ],
        'delete' => [
            'label' => 'Elimina criterio',
            'success' => 'Criterio di precedenza eliminato con successo',
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
        'reorderRecords' => [
            'tooltip' => 'reorderRecords',
            'icon' => 'reorderRecords',
            'label' => 'reorderRecords',
        ],
        'openColumnManager' => [
            'tooltip' => 'openColumnManager',
            'icon' => 'openColumnManager',
            'label' => 'openColumnManager',
        ],
        'cancel' => [
            'tooltip' => 'cancel',
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
        'resetColumnManager' => [
            'tooltip' => 'resetColumnManager',
            'icon' => 'resetColumnManager',
            'label' => 'resetColumnManager',
        ],
        'copy_from_last_year' => [
            'label' => 'copy_from_last_year',
            'icon' => 'copy_from_last_year',
            'tooltip' => 'copy_from_last_year',
        ],
        'layout' => [
            'label' => 'layout',
            'icon' => 'layout',
            'tooltip' => 'layout',
        ],
        'openFilters' => [
            'label' => 'openFilters',
            'icon' => 'openFilters',
            'tooltip' => 'openFilters',
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
            'description' => 'Visualizza tutti i criteri di precedenza',
        ],
        'create' => [
            'label' => 'Aggiungi',
            'description' => 'Crea un nuovo criterio di precedenza',
        ],
        'edit' => [
            'label' => 'Modifica',
            'description' => 'Modifica il criterio di precedenza selezionato',
        ],
    ],
    'messages' => [
        'created' => 'Criterio di precedenza creato con successo',
        'updated' => 'Criterio di precedenza aggiornato con successo',
        'deleted' => 'Criterio di precedenza eliminato con successo',
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
    'label' => 'criteri precedenza',
];
