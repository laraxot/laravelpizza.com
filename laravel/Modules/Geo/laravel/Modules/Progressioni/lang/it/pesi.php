<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Peso',
        'plural' => 'Pesi',
        'group' => [
            'name' => 'Gestione Progressioni',
            'description' => 'Gestione completa delle progressioni di carriera',
        ],
        'sort' => 4,
        'icon' => 'heroicon-o-scale',
        'label' => 'Pesi',
    ],
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome del peso',
            'help' => 'Nome identificativo del peso',
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
            'help' => 'Risorse collegate a questo peso',
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
        'anno' => [
            'description' => 'anno',
            'helper_text' => 'anno',
            'placeholder' => 'anno',
            'label' => 'anno',
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
        'layout' => [
            'label' => 'layout',
        ],
        'create' => [
            'label' => 'create',
        ],
        'peso_qualita_prestazione' => [
            'label' => 'peso_qualita_prestazione',
            'description' => 'peso_qualita_prestazione',
            'helper_text' => 'peso_qualita_prestazione',
            'placeholder' => 'peso_qualita_prestazione',
        ],
        'peso_impegno' => [
            'label' => 'peso_impegno',
            'description' => 'peso_impegno',
            'helper_text' => 'peso_impegno',
            'placeholder' => 'peso_impegno',
        ],
        'peso_arricchimento_professionale' => [
            'label' => 'peso_arricchimento_professionale',
            'description' => 'peso_arricchimento_professionale',
            'helper_text' => 'peso_arricchimento_professionale',
            'placeholder' => 'peso_arricchimento_professionale',
        ],
        'peso_risultati_ottenuti' => [
            'label' => 'peso_risultati_ottenuti',
            'placeholder' => 'peso_risultati_ottenuti',
            'helper_text' => 'peso_risultati_ottenuti',
            'description' => 'peso_risultati_ottenuti',
        ],
        'peso_esperienza_acquisita' => [
            'label' => 'peso_esperienza_acquisita',
            'placeholder' => 'peso_esperienza_acquisita',
            'helper_text' => 'peso_esperienza_acquisita',
            'description' => 'peso_esperienza_acquisita',
        ],
        'descr' => [
            'label' => 'descr',
            'placeholder' => 'descr',
            'helper_text' => 'descr',
            'description' => 'descr',
        ],
        'lista_propro' => [
            'label' => 'lista_propro',
            'placeholder' => 'lista_propro',
            'helper_text' => 'lista_propro',
            'description' => 'lista_propro',
        ],
        'id' => [
            'label' => 'id',
            'placeholder' => 'id',
            'helper_text' => 'id',
            'description' => 'id',
        ],
        'azioni' => [
            'label' => 'azioni',
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
            'filename_prefix' => 'Pesi_',
            'columns' => [
                'name' => [
                    'label' => 'Nome peso',
                    'help' => 'Nome del peso',
                ],
                'parent_name' => [
                    'label' => 'Nome elemento padre',
                    'help' => 'Nome dell\'elemento di livello superiore',
                ],
            ],
        ],
        'create' => [
            'label' => 'Nuovo peso',
            'success' => 'Peso creato con successo',
            'error' => 'Errore durante la creazione del peso',
            'icon' => 'create',
            'tooltip' => 'create',
        ],
        'edit' => [
            'label' => 'Modifica peso',
            'success' => 'Peso aggiornato con successo',
            'error' => 'Errore durante l\'aggiornamento del peso',
            'icon' => 'edit',
            'tooltip' => 'edit',
        ],
        'delete' => [
            'label' => 'Elimina peso',
            'success' => 'Peso eliminato con successo',
            'error' => 'Errore durante l\'eliminazione del peso',
            'confirmation' => 'Sei sicuro di voler eliminare questo peso? Questa azione è irreversibile.',
            'icon' => 'delete',
            'tooltip' => 'delete',
        ],
        'view' => [
            'label' => 'Visualizza peso',
            'icon' => 'view',
            'tooltip' => 'view',
        ],
        'copy_from_last_year' => [
            'label' => 'copy_from_last_year',
            'icon' => 'copy_from_last_year',
            'tooltip' => 'copy_from_last_year',
        ],
        'logout' => [
            'tooltip' => 'logout',
            'icon' => 'logout',
            'label' => 'logout',
        ],
        'removeAllFilters' => [
            'tooltip' => 'removeAllFilters',
            'icon' => 'removeAllFilters',
            'label' => 'removeAllFilters',
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
    'tabs' => [
        'index' => [
            'label' => 'Lista',
            'description' => 'Visualizza tutti i pesi',
        ],
        'create' => [
            'label' => 'Aggiungi',
            'description' => 'Crea un nuovo peso',
        ],
    ],
    'messages' => [
        'created' => 'Peso creato con successo',
        'updated' => 'Peso aggiornato con successo',
        'deleted' => 'Peso eliminato con successo',
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
        'label' => 'Modello Pesi',
        'placeholder' => 'Seleziona modello pesi',
        'tooltip' => 'Modello dati per i pesi dei criteri',
        'helper_text' => 'Rappresentazione del modello dati utilizzato per gestire i pesi e le ponderazioni dei criteri di valutazione',
        'help' => 'Modello che definisce la struttura dati per i pesi dei criteri',
    ],
    'label' => 'pesi',
];
