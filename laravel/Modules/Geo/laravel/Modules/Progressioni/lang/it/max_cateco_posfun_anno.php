<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Massimo Categoria/Posizione',
        'plural' => 'Massimi Categoria/Posizione',
        'group' => [
            'name' => 'Gestione Progressioni',
            'description' => 'Gestione completa delle progressioni di carriera',
        ],
        'sort' => 10,
        'icon' => 'heroicon-o-chart-bar-square',
        'label' => 'Massimi Categoria/Posizione',
    ],
    'fields' => [
        'id' => [
            'label' => 'ID',
            'placeholder' => 'ID univoco',
            'help' => 'Identificativo univoco del record',
        ],
        'anno' => [
            'label' => 'Anno',
            'placeholder' => 'Seleziona l\'anno di riferimento',
            'help' => 'Anno di riferimento per i massimi consentiti',
        ],
        'categoria_eco' => [
            'label' => 'Categoria Economica',
            'placeholder' => 'Seleziona la categoria economica',
            'help' => 'Categoria economica di riferimento per il calcolo dei massimi',
        ],
        'posfun' => [
            'label' => 'Posizione Funzionale',
            'placeholder' => 'Seleziona la posizione funzionale',
            'help' => 'Posizione funzionale di riferimento per il calcolo dei massimi',
        ],
        'max_value' => [
            'label' => 'Valore Massimo',
            'placeholder' => 'Inserisci il valore massimo',
            'help' => 'Valore massimo consentito per la combinazione categoria/posizione/anno',
        ],
        'percentage' => [
            'label' => 'Percentuale',
            'placeholder' => 'Inserisci la percentuale',
            'help' => 'Percentuale massima applicabile',
        ],
        'notes' => [
            'label' => 'Note',
            'placeholder' => 'Inserisci eventuali note',
            'help' => 'Note aggiuntive o commenti sul massimo',
        ],
        'is_active' => [
            'label' => 'Attivo',
            'placeholder' => 'Seleziona se attivo',
            'help' => 'Indica se il massimo è attualmente attivo',
        ],
        'data_inizio' => [
            'label' => 'Data Inizio',
            'placeholder' => 'Seleziona la data di inizio validità',
            'help' => 'Data di inizio validità del massimo',
        ],
        'data_fine' => [
            'label' => 'Data Fine',
            'placeholder' => 'Seleziona la data di fine validità',
            'help' => 'Data di fine validità del massimo',
        ],
        'created_at' => [
            'label' => 'Creato il',
            'placeholder' => 'Data di creazione',
            'help' => 'Data e ora di creazione del record',
            'description' => 'created_at',
            'helper_text' => 'created_at',
        ],
        'updated_at' => [
            'label' => 'Aggiornato il',
            'placeholder' => 'Data di aggiornamento',
            'help' => 'Data e ora dell\'ultimo aggiornamento',
            'description' => 'updated_at',
            'helper_text' => 'updated_at',
        ],
        'created_by' => [
            'label' => 'Creato da',
            'placeholder' => 'Utente che ha creato',
            'help' => 'Utente che ha creato il record',
        ],
        'updated_by' => [
            'label' => 'Aggiornato da',
            'placeholder' => 'Utente che ha aggiornato',
            'help' => 'Utente che ha effettuato l\'ultimo aggiornamento',
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
            'description' => 'value',
            'helper_text' => 'value',
            'placeholder' => 'value',
            'label' => 'value',
        ],
        'check' => [
            'label' => 'check',
        ],
        'delete' => [
            'label' => 'delete',
        ],
        'cateco' => [
            'label' => 'cateco',
        ],
        'max_gg_tot_pond' => [
            'label' => 'max_gg_tot_pond',
        ],
        'aventi_diritto' => [
            'label' => 'aventi_diritto',
        ],
        'aventi_diritto_perc' => [
            'label' => 'aventi_diritto_perc',
        ],
        'aventi_diritto_eff' => [
            'label' => 'aventi_diritto_eff',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Nuovo Massimo',
            'success' => 'Massimo creato con successo',
            'error' => 'Errore durante la creazione del massimo',
            'confirmation' => 'Sei sicuro di voler creare questo massimo?',
            'icon' => 'create',
            'tooltip' => 'create',
        ],
        'edit' => [
            'label' => 'Modifica Massimo',
            'success' => 'Massimo aggiornato con successo',
            'error' => 'Errore durante l\'aggiornamento del massimo',
            'confirmation' => 'Sei sicuro di voler modificare questo massimo?',
            'icon' => 'edit',
            'tooltip' => 'edit',
        ],
        'delete' => [
            'label' => 'Elimina Massimo',
            'success' => 'Massimo eliminato con successo',
            'error' => 'Errore durante l\'eliminazione del massimo',
            'confirmation' => 'Sei sicuro di voler eliminare questo massimo? Questa azione è irreversibile.',
            'icon' => 'delete',
            'tooltip' => 'delete',
        ],
        'view' => [
            'label' => 'Visualizza Massimo',
            'success' => 'Dettagli massimo caricati',
            'error' => 'Errore durante il caricamento dei dettagli',
            'icon' => 'view',
            'tooltip' => 'view',
        ],
        'duplicate' => [
            'label' => 'Duplica Massimo',
            'success' => 'Massimo duplicato con successo',
            'error' => 'Errore durante la duplicazione del massimo',
            'confirmation' => 'Sei sicuro di voler duplicare questo massimo?',
        ],
        'activate' => [
            'label' => 'Attiva Massimo',
            'success' => 'Massimo attivato con successo',
            'error' => 'Errore durante l\'attivazione del massimo',
            'confirmation' => 'Sei sicuro di voler attivare questo massimo?',
        ],
        'deactivate' => [
            'label' => 'Disattiva Massimo',
            'success' => 'Massimo disattivato con successo',
            'error' => 'Errore durante la disattivazione del massimo',
            'confirmation' => 'Sei sicuro di voler disattivare questo massimo?',
        ],
        'import' => [
            'label' => 'Importa Massimi',
            'success' => 'Importazione massimi completata con successo',
            'error' => 'Errore durante l\'importazione dei massimi',
            'confirmation' => 'Sei sicuro di voler importare i massimi dal file selezionato?',
            'fields' => [
                'file' => [
                    'label' => 'File da importare',
                    'placeholder' => 'Seleziona un file XLS o CSV',
                    'help' => 'Formati supportati: XLS, XLSX, CSV. Dimensione massima: 10MB',
                ],
            ],
        ],
        'export' => [
            'label' => 'Esporta Massimi',
            'success' => 'Esportazione massimi completata con successo',
            'error' => 'Errore durante l\'esportazione dei massimi',
            'filename_prefix' => 'Massimi_Categoria_Posizione_',
        ],
        'bulk_delete' => [
            'label' => 'Elimina Selezionati',
            'success' => 'Massimi eliminati con successo',
            'error' => 'Errore durante l\'eliminazione dei massimi',
            'confirmation' => 'Sei sicuro di voler eliminare i massimi selezionati? Questa azione è irreversibile.',
        ],
        'bulk_activate' => [
            'label' => 'Attiva Selezionati',
            'success' => 'Massimi attivati con successo',
            'error' => 'Errore durante l\'attivazione dei massimi',
            'confirmation' => 'Sei sicuro di voler attivare i massimi selezionati?',
        ],
        'bulk_deactivate' => [
            'label' => 'Disattiva Selezionati',
            'success' => 'Massimi disattivati con successo',
            'error' => 'Errore durante la disattivazione dei massimi',
            'confirmation' => 'Sei sicuro di voler disattivare i massimi selezionati?',
        ],
        'logout' => [
            'tooltip' => 'logout',
            'icon' => 'logout',
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
    'messages' => [
        'welcome' => 'Benvenuto nella gestione dei massimi per categoria e posizione funzionale',
        'no_data' => 'Nessun massimo trovato per i criteri selezionati',
        'loading' => 'Caricamento massimi in corso...',
        'search_placeholder' => 'Cerca per anno, categoria o posizione...',
        'filter_by_year' => 'Filtra per anno',
        'filter_by_category' => 'Filtra per categoria',
        'filter_by_position' => 'Filtra per posizione',
        'clear_filters' => 'Pulisci filtri',
        'apply_filters' => 'Applica filtri',
        'results_count' => 'Trovati :count risultati',
        'selected_count' => ':count elementi selezionati',
    ],
    'validation' => [
        'anno' => [
            'required' => 'L\'anno è obbligatorio',
            'numeric' => 'L\'anno deve essere un numero',
            'min' => 'L\'anno deve essere almeno :min',
            'max' => 'L\'anno non può essere maggiore di :max',
            'current_or_past' => 'L\'anno non può essere futuro',
        ],
        'categoria_eco' => [
            'required' => 'La categoria economica è obbligatoria',
            'string' => 'La categoria economica deve essere una stringa',
            'max' => 'La categoria economica non può superare :max caratteri',
            'exists' => 'La categoria economica selezionata non è valida',
        ],
        'posfun' => [
            'required' => 'La posizione funzionale è obbligatoria',
            'string' => 'La posizione funzionale deve essere una stringa',
            'max' => 'La posizione funzionale non può superare :max caratteri',
            'exists' => 'La posizione funzionale selezionata non è valida',
        ],
        'max_value' => [
            'required' => 'Il valore massimo è obbligatorio',
            'numeric' => 'Il valore massimo deve essere numerico',
            'min' => 'Il valore massimo deve essere almeno :min',
            'max' => 'Il valore massimo non può essere maggiore di :max',
        ],
        'percentage' => [
            'numeric' => 'La percentuale deve essere numerica',
            'min' => 'La percentuale deve essere almeno :min',
            'max' => 'La percentuale non può essere maggiore di :max',
        ],
        'data_inizio' => [
            'date' => 'La data di inizio deve essere una data valida',
            'before_or_equal' => 'La data di inizio deve essere precedente o uguale alla data di fine',
        ],
        'data_fine' => [
            'date' => 'La data di fine deve essere una data valida',
            'after_or_equal' => 'La data di fine deve essere successiva o uguale alla data di inizio',
        ],
        'unique_combination' => 'Esiste già un massimo per questa combinazione anno/categoria/posizione funzionale nel periodo specificato',
        'overlapping_periods' => 'Il periodo specificato si sovrappone con un massimo esistente per la stessa combinazione',
    ],
    'filters' => [
        'year' => [
            'label' => 'Anno',
            'placeholder' => 'Seleziona anno',
            'all' => 'Tutti gli anni',
        ],
        'category' => [
            'label' => 'Categoria',
            'placeholder' => 'Seleziona categoria',
            'all' => 'Tutte le categorie',
        ],
        'position' => [
            'label' => 'Posizione',
            'placeholder' => 'Seleziona posizione',
            'all' => 'Tutte le posizioni',
        ],
        'status' => [
            'label' => 'Stato',
            'placeholder' => 'Seleziona stato',
            'all' => 'Tutti gli stati',
            'active' => 'Attivi',
            'inactive' => 'Inattivi',
        ],
    ],
    'tabs' => [
        'general' => [
            'label' => 'Informazioni Generali',
            'description' => 'Dati principali del massimo',
        ],
        'details' => [
            'label' => 'Dettagli',
            'description' => 'Informazioni dettagliate e configurazioni',
        ],
        'history' => [
            'label' => 'Storico',
            'description' => 'Cronologia delle modifiche',
        ],
        'audit' => [
            'label' => 'Audit',
            'description' => 'Log delle operazioni',
        ],
    ],
    'label' => 'max cateco posfun anno',
];
