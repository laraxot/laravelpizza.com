<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Coefficiente',
        'plural' => 'Coefficienti',
        'group' => [
            'name' => 'Gestione Progressioni',
            'description' => 'Gestione completa delle progressioni di carriera',
        ],
        'sort' => 8,
        'icon' => 'heroicon-o-calculator',
        'label' => 'Coefficienti',
    ],
    'fields' => [
        'id' => [
            'label' => 'ID',
            'placeholder' => 'ID univoco',
            'help' => 'Identificativo univoco del coefficiente',
        ],
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome del coefficiente',
            'help' => 'Nome identificativo del coefficiente',
        ],
        'codice' => [
            'label' => 'Codice',
            'placeholder' => 'Inserisci il codice del coefficiente',
            'help' => 'Codice identificativo univoco del coefficiente',
        ],
        'valore' => [
            'label' => 'Valore',
            'placeholder' => 'Inserisci il valore del coefficiente',
            'help' => 'Valore numerico del coefficiente utilizzato nei calcoli',
        ],
        'tipo' => [
            'label' => 'Tipo',
            'placeholder' => 'Seleziona il tipo di coefficiente',
            'help' => 'Tipologia del coefficiente (moltiplicativo, additivo, percentuale)',
            'options' => [
                'moltiplicativo' => 'Moltiplicativo',
                'additivo' => 'Additivo',
                'percentuale' => 'Percentuale',
                'fisso' => 'Fisso',
                'variabile' => 'Variabile',
            ],
        ],
        'descrizione' => [
            'label' => 'Descrizione',
            'placeholder' => 'Inserisci la descrizione del coefficiente',
            'help' => 'Descrizione dettagliata del coefficiente e del suo utilizzo',
        ],
        'formula' => [
            'label' => 'Formula',
            'placeholder' => 'Inserisci la formula di calcolo',
            'help' => 'Formula matematica utilizzata per il calcolo del coefficiente',
        ],
        'unita_misura' => [
            'label' => 'Unità di Misura',
            'placeholder' => 'Inserisci l\'unità di misura',
            'help' => 'Unità di misura del coefficiente (%, €, punti, etc.)',
        ],
        'categoria' => [
            'label' => 'Categoria',
            'placeholder' => 'Seleziona la categoria',
            'help' => 'Categoria di appartenenza del coefficiente',
        ],
        'sottocategoria' => [
            'label' => 'Sottocategoria',
            'placeholder' => 'Seleziona la sottocategoria',
            'help' => 'Sottocategoria specifica del coefficiente',
        ],
        'applicabile_a' => [
            'label' => 'Applicabile a',
            'placeholder' => 'Seleziona a cosa è applicabile',
            'help' => 'Definisce a quali elementi è applicabile questo coefficiente',
            'options' => [
                'tutti' => 'Tutti i dipendenti',
                'categoria_eco' => 'Categoria economica',
                'posizione_funzionale' => 'Posizione funzionale',
                'stabilimento' => 'Stabilimento',
                'reparto' => 'Reparto',
                'profilo_professionale' => 'Profilo professionale',
            ],
        ],
        'priorita' => [
            'label' => 'Priorità',
            'placeholder' => 'Inserisci la priorità',
            'help' => 'Ordine di priorità nell\'applicazione del coefficiente (1 = massima priorità)',
        ],
        'peso' => [
            'label' => 'Peso',
            'placeholder' => 'Inserisci il peso del coefficiente',
            'help' => 'Peso relativo del coefficiente nel calcolo complessivo',
        ],
        'valore_minimo' => [
            'label' => 'Valore Minimo',
            'placeholder' => 'Inserisci il valore minimo',
            'help' => 'Valore minimo consentito per questo coefficiente',
        ],
        'valore_massimo' => [
            'label' => 'Valore Massimo',
            'placeholder' => 'Inserisci il valore massimo',
            'help' => 'Valore massimo consentito per questo coefficiente',
        ],
        'valore_default' => [
            'label' => 'Valore Default',
            'placeholder' => 'Inserisci il valore di default',
            'help' => 'Valore predefinito utilizzato se non specificato diversamente',
        ],
        'data_inizio' => [
            'label' => 'Data Inizio Validità',
            'placeholder' => 'Seleziona la data di inizio',
            'help' => 'Data di inizio validità del coefficiente',
        ],
        'data_fine' => [
            'label' => 'Data Fine Validità',
            'placeholder' => 'Seleziona la data di fine',
            'help' => 'Data di fine validità del coefficiente',
        ],
        'anno_riferimento' => [
            'label' => 'Anno di Riferimento',
            'placeholder' => 'Seleziona l\'anno di riferimento',
            'help' => 'Anno per il quale è valido questo coefficiente',
        ],
        'stato' => [
            'label' => 'Stato',
            'placeholder' => 'Seleziona lo stato',
            'help' => 'Stato attuale del coefficiente',
            'options' => [
                'attivo' => 'Attivo',
                'inattivo' => 'Inattivo',
                'bozza' => 'Bozza',
                'approvato' => 'Approvato',
                'scaduto' => 'Scaduto',
                'sospeso' => 'Sospeso',
            ],
        ],
        'note' => [
            'label' => 'Note',
            'placeholder' => 'Inserisci eventuali note',
            'help' => 'Note aggiuntive o commenti sul coefficiente',
        ],
        'created_at' => [
            'label' => 'Creato il',
            'placeholder' => 'Data di creazione',
            'help' => 'Data e ora di creazione del coefficiente',
        ],
        'updated_at' => [
            'label' => 'Aggiornato il',
            'placeholder' => 'Data di aggiornamento',
            'help' => 'Data e ora dell\'ultimo aggiornamento',
        ],
        'created_by' => [
            'label' => 'Creato da',
            'placeholder' => 'Utente che ha creato',
            'help' => 'Utente che ha creato il coefficiente',
        ],
        'updated_by' => [
            'label' => 'Aggiornato da',
            'placeholder' => 'Utente che ha aggiornato',
            'help' => 'Utente che ha effettuato l\'ultimo aggiornamento',
        ],
        'parent' => [
            'label' => 'Coefficiente Padre',
            'placeholder' => 'Seleziona il coefficiente padre',
            'help' => 'Coefficiente di livello superiore nella gerarchia',
        ],
        'parent_name' => [
            'label' => 'Nome Coefficiente Padre',
            'placeholder' => 'Nome del coefficiente padre',
            'help' => 'Nome del coefficiente di livello superiore',
        ],
        'assets' => [
            'label' => 'Risorse Associate',
            'placeholder' => 'Seleziona le risorse',
            'help' => 'Documenti o risorse collegate a questo coefficiente',
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
        'anno' => [
            'label' => 'anno',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Nuovo Coefficiente',
            'success' => 'Coefficiente creato con successo',
            'error' => 'Errore durante la creazione del coefficiente',
            'confirmation' => 'Sei sicuro di voler creare questo coefficiente?',
            'icon' => 'create',
            'tooltip' => 'create',
        ],
        'edit' => [
            'label' => 'Modifica Coefficiente',
            'success' => 'Coefficiente aggiornato con successo',
            'error' => 'Errore durante l\'aggiornamento del coefficiente',
            'confirmation' => 'Sei sicuro di voler modificare questo coefficiente?',
            'icon' => 'edit',
            'tooltip' => 'edit',
        ],
        'delete' => [
            'label' => 'Elimina Coefficiente',
            'success' => 'Coefficiente eliminato con successo',
            'error' => 'Errore durante l\'eliminazione del coefficiente',
            'confirmation' => 'Sei sicuro di voler eliminare questo coefficiente? Questa azione è irreversibile.',
            'icon' => 'delete',
            'tooltip' => 'delete',
        ],
        'view' => [
            'label' => 'Visualizza Coefficiente',
            'success' => 'Dettagli coefficiente caricati',
            'error' => 'Errore durante il caricamento dei dettagli',
            'icon' => 'view',
            'tooltip' => 'view',
        ],
        'duplicate' => [
            'label' => 'Duplica Coefficiente',
            'success' => 'Coefficiente duplicato con successo',
            'error' => 'Errore durante la duplicazione del coefficiente',
            'confirmation' => 'Sei sicuro di voler duplicare questo coefficiente?',
        ],
        'calculate' => [
            'label' => 'Calcola Coefficiente',
            'success' => 'Calcolo coefficiente completato con successo',
            'error' => 'Errore durante il calcolo del coefficiente',
            'confirmation' => 'Sei sicuro di voler ricalcolare questo coefficiente?',
        ],
        'test_formula' => [
            'label' => 'Testa Formula',
            'success' => 'Test formula completato con successo',
            'error' => 'Errore durante il test della formula',
            'confirmation' => 'Vuoi testare la formula di questo coefficiente?',
        ],
        'activate' => [
            'label' => 'Attiva Coefficiente',
            'success' => 'Coefficiente attivato con successo',
            'error' => 'Errore durante l\'attivazione del coefficiente',
            'confirmation' => 'Sei sicuro di voler attivare questo coefficiente?',
        ],
        'deactivate' => [
            'label' => 'Disattiva Coefficiente',
            'success' => 'Coefficiente disattivato con successo',
            'error' => 'Errore durante la disattivazione del coefficiente',
            'confirmation' => 'Sei sicuro di voler disattivare questo coefficiente?',
        ],
        'approve' => [
            'label' => 'Approva Coefficiente',
            'success' => 'Coefficiente approvato con successo',
            'error' => 'Errore durante l\'approvazione del coefficiente',
            'confirmation' => 'Sei sicuro di voler approvare questo coefficiente?',
        ],
        'reject' => [
            'label' => 'Rifiuta Coefficiente',
            'success' => 'Coefficiente rifiutato con successo',
            'error' => 'Errore durante il rifiuto del coefficiente',
            'confirmation' => 'Sei sicuro di voler rifiutare questo coefficiente?',
        ],
        'import' => [
            'label' => 'Importa Coefficienti',
            'success' => 'Importazione coefficienti completata con successo',
            'error' => 'Errore durante l\'importazione dei coefficienti',
            'confirmation' => 'Sei sicuro di voler importare i coefficienti dal file selezionato?',
            'fields' => [
                'file' => [
                    'label' => 'File da importare',
                    'placeholder' => 'Seleziona un file XLS o CSV',
                    'help' => 'Formati supportati: XLS, XLSX, CSV. Dimensione massima: 10MB',
                ],
            ],
        ],
        'export' => [
            'label' => 'Esporta Coefficienti',
            'success' => 'Esportazione coefficienti completata con successo',
            'error' => 'Errore durante l\'esportazione dei coefficienti',
            'filename_prefix' => 'Coefficienti_',
        ],
        'bulk_delete' => [
            'label' => 'Elimina Selezionati',
            'success' => 'Coefficienti eliminati con successo',
            'error' => 'Errore durante l\'eliminazione dei coefficienti',
            'confirmation' => 'Sei sicuro di voler eliminare i coefficienti selezionati? Questa azione è irreversibile.',
        ],
        'bulk_activate' => [
            'label' => 'Attiva Selezionati',
            'success' => 'Coefficienti attivati con successo',
            'error' => 'Errore durante l\'attivazione dei coefficienti',
            'confirmation' => 'Sei sicuro di voler attivare i coefficienti selezionati?',
        ],
        'bulk_calculate' => [
            'label' => 'Calcola Selezionati',
            'success' => 'Calcolo coefficienti completato con successo',
            'error' => 'Errore durante il calcolo dei coefficienti',
            'confirmation' => 'Sei sicuro di voler ricalcolare i coefficienti selezionati?',
        ],
        'logout' => [
            'tooltip' => 'logout',
            'icon' => 'logout',
            'label' => 'logout',
        ],
        'profile' => [
            'tooltip' => 'profile',
            'label' => 'profile',
            'icon' => 'profile',
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
    ],
    'messages' => [
        'welcome' => 'Benvenuto nella gestione dei coefficienti',
        'no_data' => 'Nessun coefficiente trovato per i criteri selezionati',
        'loading' => 'Caricamento coefficienti in corso...',
        'calculating' => 'Calcolo in corso...',
        'search_placeholder' => 'Cerca per nome, codice o descrizione...',
        'filter_by_type' => 'Filtra per tipo',
        'filter_by_category' => 'Filtra per categoria',
        'filter_by_status' => 'Filtra per stato',
        'clear_filters' => 'Pulisci filtri',
        'apply_filters' => 'Applica filtri',
        'results_count' => 'Trovati :count risultati',
        'selected_count' => ':count elementi selezionati',
        'formula_valid' => 'Formula valida',
        'formula_invalid' => 'Formula non valida',
        'calculation_completed' => 'Calcolo completato',
        'test_successful' => 'Test completato con successo',
    ],
    'validation' => [
        'name' => [
            'required' => 'Il nome del coefficiente è obbligatorio',
            'string' => 'Il nome deve essere una stringa',
            'max' => 'Il nome non può superare :max caratteri',
            'unique' => 'Il nome del coefficiente è già presente',
        ],
        'codice' => [
            'required' => 'Il codice è obbligatorio',
            'string' => 'Il codice deve essere una stringa',
            'max' => 'Il codice non può superare :max caratteri',
            'unique' => 'Il codice deve essere unico',
            'alpha_num' => 'Il codice può contenere solo lettere e numeri',
        ],
        'valore' => [
            'required' => 'Il valore è obbligatorio',
            'numeric' => 'Il valore deve essere numerico',
            'min' => 'Il valore deve essere almeno :min',
            'max' => 'Il valore non può essere maggiore di :max',
        ],
        'tipo' => [
            'required' => 'Il tipo è obbligatorio',
            'in' => 'Il tipo selezionato non è valido',
        ],
        'formula' => [
            'required_if' => 'La formula è obbligatoria per coefficienti calcolati',
            'string' => 'La formula deve essere una stringa',
            'max' => 'La formula non può superare :max caratteri',
        ],
        'data_inizio' => [
            'date' => 'La data di inizio deve essere una data valida',
            'before_or_equal' => 'La data di inizio deve essere precedente o uguale alla data di fine',
        ],
        'data_fine' => [
            'date' => 'La data di fine deve essere una data valida',
            'after_or_equal' => 'La data di fine deve essere successiva o uguale alla data di inizio',
        ],
        'anno_riferimento' => [
            'numeric' => 'L\'anno di riferimento deve essere un numero',
            'min' => 'L\'anno di riferimento deve essere almeno :min',
            'max' => 'L\'anno di riferimento non può essere maggiore di :max',
        ],
        'priorita' => [
            'numeric' => 'La priorità deve essere un numero',
            'min' => 'La priorità deve essere almeno :min',
        ],
        'peso' => [
            'numeric' => 'Il peso deve essere numerico',
            'min' => 'Il peso deve essere almeno :min',
            'max' => 'Il peso non può essere maggiore di :max',
        ],
        'valore_minimo' => [
            'numeric' => 'Il valore minimo deve essere numerico',
            'lte' => 'Il valore minimo deve essere minore o uguale al valore massimo',
        ],
        'valore_massimo' => [
            'numeric' => 'Il valore massimo deve essere numerico',
            'gte' => 'Il valore massimo deve essere maggiore o uguale al valore minimo',
        ],
        'applicabile_a' => [
            'required' => 'Il campo applicabile a è obbligatorio',
            'in' => 'Il valore selezionato per applicabile a non è valido',
        ],
        'stato' => [
            'required' => 'Lo stato è obbligatorio',
            'in' => 'Lo stato selezionato non è valido',
        ],
    ],
    'filters' => [
        'type' => [
            'label' => 'Tipo',
            'placeholder' => 'Seleziona tipo',
            'all' => 'Tutti i tipi',
        ],
        'category' => [
            'label' => 'Categoria',
            'placeholder' => 'Seleziona categoria',
            'all' => 'Tutte le categorie',
        ],
        'status' => [
            'label' => 'Stato',
            'placeholder' => 'Seleziona stato',
            'all' => 'Tutti gli stati',
        ],
        'year' => [
            'label' => 'Anno',
            'placeholder' => 'Seleziona anno',
            'all' => 'Tutti gli anni',
        ],
    ],
    'tabs' => [
        'general' => [
            'label' => 'Informazioni Generali',
            'description' => 'Dati principali del coefficiente',
        ],
        'calculation' => [
            'label' => 'Calcolo',
            'description' => 'Formula e parametri di calcolo',
        ],
        'validity' => [
            'label' => 'Validità',
            'description' => 'Periodo di validità e applicabilità',
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
    'label' => 'coeff',
];
