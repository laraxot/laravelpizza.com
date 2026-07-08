<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Stipendio Tabellare',
        'plural' => 'Stipendi Tabellari',
        'group' => [
            'name' => 'Gestione Progressioni',
            'description' => 'Gestione completa delle progressioni di carriera',
        ],
        'sort' => 15,
        'icon' => 'heroicon-o-currency-dollar',
        'label' => 'Stipendi Tabellari',
    ],
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome dello stipendio tabellare',
            'help' => 'Nome identificativo dello stipendio tabellare',
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
            'help' => 'Risorse collegate a questo stipendio tabellare',
        ],
        'toggleColumns' => [
            'label' => 'Mostra/Nascondi Colonne',
            'help' => 'Gestisci la visibilità delle colonne',
        ],
        'id' => [
            'label' => 'ID',
            'help' => 'Identificativo univoco dello stipendio tabellare',
        ],
        'cateco' => [
            'label' => 'Categoria Economica',
            'placeholder' => 'Seleziona la categoria economica',
            'help' => 'Categoria economica del dipendente',
        ],
        'posfun' => [
            'label' => 'Posizione Funzionale',
            'placeholder' => 'Seleziona la posizione funzionale',
            'help' => 'Posizione funzionale del dipendente',
        ],
        'importo' => [
            'label' => 'Importo',
            'placeholder' => 'Inserisci l\'importo dello stipendio',
            'help' => 'Importo dello stipendio tabellare',
        ],
        'anno' => [
            'label' => 'Anno',
            'placeholder' => 'Inserisci l\'anno di riferimento',
            'help' => 'Anno di riferimento dello stipendio',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
            'help' => 'Data di creazione del record',
            'placeholder' => 'created_at',
            'helper_text' => 'created_at',
            'description' => 'created_at',
        ],
        'updated_at' => [
            'label' => 'Data Aggiornamento',
            'help' => 'Data dell\'ultimo aggiornamento',
            'placeholder' => 'updated_at',
            'helper_text' => 'updated_at',
            'description' => 'updated_at',
        ],
        'openFilters' => [
            'label' => 'Apri Filtri',
            'help' => 'Apri il pannello dei filtri',
        ],
        'applyFilters' => [
            'label' => 'Applica Filtri',
            'help' => 'Applica i filtri selezionati',
        ],
        'resetFilters' => [
            'label' => 'Resetta Filtri',
            'help' => 'Rimuovi tutti i filtri applicati',
        ],
        'reorderRecords' => [
            'label' => 'Riordina Record',
            'help' => 'Riordina i record nella tabella',
        ],
        'categoria_eco' => [
            'label' => 'Categoria Economica',
            'placeholder' => 'Seleziona la categoria economica',
            'help' => 'Categoria economica di riferimento',
        ],
        'posizione_funzionale' => [
            'label' => 'Posizione Funzionale',
            'placeholder' => 'Seleziona la posizione funzionale',
            'help' => 'Posizione funzionale di riferimento',
        ],
        'data_inizio' => [
            'label' => 'Data Inizio',
            'placeholder' => 'Seleziona la data di inizio validità',
            'help' => 'Data di inizio validità dello stipendio',
        ],
        'data_fine' => [
            'label' => 'Data Fine',
            'placeholder' => 'Seleziona la data di fine validità',
            'help' => 'Data di fine validità dello stipendio',
        ],
        'stato' => [
            'label' => 'Stato',
            'placeholder' => 'Seleziona lo stato',
            'help' => 'Stato attuale dello stipendio tabellare',
        ],
        'note' => [
            'label' => 'Note',
            'placeholder' => 'Inserisci eventuali note',
            'help' => 'Note aggiuntive sullo stipendio tabellare',
        ],
        'approvato' => [
            'label' => 'Approvato',
            'help' => 'Indica se lo stipendio è stato approvato',
        ],
        'approvato_da' => [
            'label' => 'Approvato da',
            'placeholder' => 'Seleziona chi ha approvato',
            'help' => 'Utente che ha approvato lo stipendio',
        ],
        'data_approvazione' => [
            'label' => 'Data Approvazione',
            'help' => 'Data di approvazione dello stipendio',
        ],
        'valuta' => [
            'label' => 'Valuta',
            'placeholder' => 'Seleziona la valuta',
            'help' => 'Valuta dello stipendio tabellare',
        ],
        'tipo_stipendio' => [
            'label' => 'Tipo Stipendio',
            'placeholder' => 'Seleziona il tipo di stipendio',
            'help' => 'Tipo di stipendio tabellare',
        ],
        'value' => [
            'description' => 'value',
            'helper_text' => 'value',
            'placeholder' => 'value',
            'label' => 'value',
        ],
        'create' => [
            'label' => 'create',
        ],
        'layout' => [
            'label' => 'layout',
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
    ],
    'actions' => [
        'import' => [
            'label' => 'Importa da file',
            'success' => 'Stipendi importati con successo',
            'error' => 'Errore durante l\'importazione degli stipendi',
            'confirmation' => 'Sei sicuro di voler importare questo file?',
            'fields' => [
                'import_file' => [
                    'label' => 'Seleziona un file XLS o CSV da caricare',
                    'placeholder' => 'Scegli un file XLS o CSV',
                    'help' => 'Formati supportati: XLS, XLSX, CSV. Dimensione massima: 10MB',
                ],
            ],
        ],
        'export' => [
            'label' => 'Esporta dati',
            'success' => 'Dati esportati con successo',
            'error' => 'Errore durante l\'esportazione',
            'filename_prefix' => 'Stipendi_Tabellari_',
            'columns' => [
                'name' => [
                    'label' => 'Nome',
                    'help' => 'Nome identificativo',
                ],
                'parent_name' => [
                    'label' => 'Nome elemento padre',
                    'help' => 'Nome dell\'elemento di livello superiore',
                ],
            ],
        ],
        'create' => [
            'label' => 'Nuovo stipendio tabellare',
            'success' => 'Stipendio tabellare creato con successo',
            'error' => 'Errore durante la creazione dello stipendio tabellare',
            'icon' => 'create',
            'tooltip' => 'create',
        ],
        'edit' => [
            'label' => 'Modifica stipendio tabellare',
            'success' => 'Stipendio tabellare aggiornato con successo',
            'error' => 'Errore durante l\'aggiornamento dello stipendio tabellare',
            'icon' => 'edit',
            'tooltip' => 'edit',
        ],
        'delete' => [
            'label' => 'Elimina stipendio tabellare',
            'success' => 'Stipendio tabellare eliminato con successo',
            'error' => 'Errore durante l\'eliminazione dello stipendio tabellare',
            'confirmation' => 'Sei sicuro di voler eliminare questo stipendio tabellare? Questa azione è irreversibile.',
            'icon' => 'delete',
            'tooltip' => 'delete',
        ],
        'view' => [
            'label' => 'Visualizza stipendio tabellare',
            'icon' => 'view',
            'tooltip' => 'view',
        ],
        'approve' => [
            'label' => 'Approva stipendio tabellare',
            'success' => 'Stipendio tabellare approvato con successo',
            'error' => 'Errore durante l\'approvazione dello stipendio tabellare',
            'confirmation' => 'Sei sicuro di voler approvare questo stipendio tabellare?',
        ],
        'reject' => [
            'label' => 'Rifiuta stipendio tabellare',
            'success' => 'Stipendio tabellare rifiutato con successo',
            'error' => 'Errore durante il rifiuto dello stipendio tabellare',
            'confirmation' => 'Sei sicuro di voler rifiutare questo stipendio tabellare?',
        ],
        'copy_from_last_year' => [
            'label' => 'copy_from_last_year',
            'icon' => 'copy_from_last_year',
            'tooltip' => 'copy_from_last_year',
        ],
        'logout' => [
            'tooltip' => 'logout',
            'icon' => 'logout',
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
        'removeAllFilters' => [
            'label' => 'removeAllFilters',
            'icon' => 'removeAllFilters',
            'tooltip' => 'removeAllFilters',
        ],
    ],
    'tabs' => [
        'index' => [
            'label' => 'Lista',
            'description' => 'Visualizza tutti gli stipendi tabellari',
        ],
        'create' => [
            'label' => 'Aggiungi',
            'description' => 'Crea un nuovo stipendio tabellare',
        ],
    ],
    'messages' => [
        'created' => 'Stipendio tabellare creato con successo',
        'updated' => 'Stipendio tabellare aggiornato con successo',
        'deleted' => 'Stipendio tabellare eliminato con successo',
        'approved' => 'Stipendio tabellare approvato con successo',
        'rejected' => 'Stipendio tabellare rifiutato con successo',
        'import_success' => 'Importazione stipendi completata con successo',
        'export_success' => 'Esportazione stipendi completata con successo',
        'no_data' => 'Nessuno stipendio tabellare trovato',
        'loading' => 'Caricamento in corso...',
        'error' => 'Si è verificato un errore',
        'success' => 'Operazione completata con successo',
    ],
    'validation' => [
        'name_required' => 'Il nome dello stipendio tabellare è obbligatorio',
        'name_unique' => 'Il nome dello stipendio tabellare è già presente',
        'categoria_eco_required' => 'La categoria economica è obbligatoria',
        'categoria_eco_exists' => 'La categoria economica selezionata non è valida',
        'posizione_funzionale_required' => 'La posizione funzionale è obbligatoria',
        'posizione_funzionale_exists' => 'La posizione funzionale selezionata non è valida',
        'importo_required' => 'L\'importo è obbligatorio',
        'importo_numeric' => 'L\'importo deve essere numerico',
        'importo_min' => 'L\'importo deve essere almeno :min',
        'importo_max' => 'L\'importo non può essere maggiore di :max',
        'anno_required' => 'L\'anno è obbligatorio',
        'anno_numeric' => 'L\'anno deve essere un numero',
        'anno_min' => 'L\'anno deve essere almeno :min',
        'anno_max' => 'L\'anno non può essere maggiore di :max',
        'data_inizio_date' => 'La data di inizio deve essere una data valida',
        'data_fine_date' => 'La data di fine deve essere una data valida',
        'data_fine_after_inizio' => 'La data di fine deve essere successiva alla data di inizio',
        'stato_required' => 'Lo stato è obbligatorio',
        'valuta_required' => 'La valuta è obbligatoria',
        'tipo_stipendio_required' => 'Il tipo di stipendio è obbligatorio',
    ],
    'model' => [
        'label' => 'Stipendio Tabellare',
        'help' => 'Gestione degli stipendi tabellari',
    ],
    'label' => 'stipendio tabellare',
];
