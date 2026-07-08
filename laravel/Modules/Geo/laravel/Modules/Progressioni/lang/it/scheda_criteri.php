<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Scheda Criteri',
        'plural' => 'Scheda Criteri',
        'group' => [
            'name' => 'Gestione Progressioni',
            'description' => 'Gestione completa delle progressioni di carriera',
        ],
        'sort' => 16,
        'icon' => 'heroicon-o-clipboard-document-check',
        'label' => 'Scheda Criteri',
    ],
    'fields' => [
        'id' => [
            'label' => 'ID',
            'placeholder' => 'ID univoco',
            'help' => 'Identificativo univoco della scheda criteri',
        ],
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome della scheda criteri',
            'help' => 'Nome identificativo della scheda criteri',
        ],
        'codice' => [
            'label' => 'Codice',
            'placeholder' => 'Inserisci il codice della scheda criteri',
            'help' => 'Codice identificativo univoco della scheda criteri',
        ],
        'descrizione' => [
            'label' => 'Descrizione',
            'placeholder' => 'Inserisci una descrizione della scheda criteri',
            'help' => 'Descrizione dettagliata della scheda criteri e del suo utilizzo',
        ],
        'tipo' => [
            'label' => 'Tipo',
            'placeholder' => 'Seleziona il tipo di scheda',
            'help' => 'Tipologia della scheda criteri',
            'options' => [
                'standard' => 'Standard',
                'personalizzata' => 'Personalizzata',
                'automatica' => 'Automatica',
                'manuale' => 'Manuale',
                'mista' => 'Mista',
            ],
        ],
        'categoria' => [
            'label' => 'Categoria',
            'placeholder' => 'Seleziona la categoria',
            'help' => 'Categoria di appartenenza della scheda criteri',
        ],
        'sottocategoria' => [
            'label' => 'Sottocategoria',
            'placeholder' => 'Seleziona la sottocategoria',
            'help' => 'Sottocategoria specifica della scheda criteri',
        ],
        'versione' => [
            'label' => 'Versione',
            'placeholder' => 'Inserisci la versione',
            'help' => 'Numero di versione della scheda criteri',
        ],
        'stato' => [
            'label' => 'Stato',
            'placeholder' => 'Seleziona lo stato',
            'help' => 'Stato attuale della scheda criteri',
            'options' => [
                'bozza' => 'Bozza',
                'attiva' => 'Attiva',
                'inattiva' => 'Inattiva',
                'approvata' => 'Approvata',
                'rifiutata' => 'Rifiutata',
                'scaduta' => 'Scaduta',
                'archiviata' => 'Archiviata',
            ],
        ],
        'data_inizio' => [
            'label' => 'Data Inizio Validità',
            'placeholder' => 'Seleziona la data di inizio',
            'help' => 'Data di inizio validità della scheda criteri',
        ],
        'data_fine' => [
            'label' => 'Data Fine Validità',
            'placeholder' => 'Seleziona la data di fine',
            'help' => 'Data di fine validità della scheda criteri',
        ],
        'anno_riferimento' => [
            'label' => 'Anno di Riferimento',
            'placeholder' => 'Seleziona l\'anno di riferimento',
            'help' => 'Anno per il quale è valida questa scheda criteri',
        ],
        'valutatore_id' => [
            'label' => 'Valutatore',
            'placeholder' => 'Seleziona il valutatore',
            'help' => 'Valutatore responsabile della scheda criteri',
        ],
        'ente' => [
            'label' => 'Ente',
            'placeholder' => 'Seleziona l\'ente',
            'help' => 'Ente di appartenenza per la scheda criteri',
        ],
        'stabilimento' => [
            'label' => 'Stabilimento',
            'placeholder' => 'Seleziona lo stabilimento',
            'help' => 'Stabilimento di riferimento per la scheda criteri',
        ],
        'reparto' => [
            'label' => 'Reparto',
            'placeholder' => 'Seleziona il reparto',
            'help' => 'Reparto di riferimento per la scheda criteri',
        ],
        'profilo_professionale' => [
            'label' => 'Profilo Professionale',
            'placeholder' => 'Seleziona il profilo professionale',
            'help' => 'Profilo professionale target per la scheda criteri',
        ],
        'categoria_economica' => [
            'label' => 'Categoria Economica',
            'placeholder' => 'Seleziona la categoria economica',
            'help' => 'Categoria economica target per la scheda criteri',
        ],
        'posizione_funzionale' => [
            'label' => 'Posizione Funzionale',
            'placeholder' => 'Seleziona la posizione funzionale',
            'help' => 'Posizione funzionale target per la scheda criteri',
        ],
        'criteri' => [
            'label' => 'Criteri',
            'placeholder' => 'Seleziona i criteri',
            'help' => 'Criteri di valutazione inclusi nella scheda',
        ],
        'peso_totale' => [
            'label' => 'Peso Totale',
            'placeholder' => 'Inserisci il peso totale',
            'help' => 'Peso totale di tutti i criteri (deve essere 100)',
        ],
        'criterio' => [
            'label' => 'Criterio',
            'placeholder' => 'Inserisci il nome del criterio',
            'tooltip' => 'Nome del criterio di valutazione',
            'helper_text' => 'Descrizione breve del criterio utilizzato per la valutazione delle progressioni',
            'help' => 'Nome identificativo del criterio di valutazione',
        ],
        'peso' => [
            'label' => 'Peso',
            'placeholder' => 'Inserisci il peso (0-100)',
            'tooltip' => 'Peso percentuale del criterio',
            'helper_text' => 'Peso percentuale che questo criterio ha nel calcolo del punteggio finale (0-100%)',
            'help' => 'Peso percentuale del criterio nella valutazione complessiva',
        ],
        'descr' => [
            'label' => 'descr',
        ],
        'is_editable' => [
            'label' => 'Modificabile',
            'placeholder' => 'Seleziona se modificabile',
            'tooltip' => 'Indica se il criterio può essere modificato',
            'helper_text' => 'Specifica se questo criterio può essere modificato dagli utenti durante la valutazione',
            'help' => 'Determina se il criterio è modificabile o fisso',
        ],
        'field_name' => [
            'label' => 'Nome Campo',
            'placeholder' => 'Inserisci il nome del campo',
            'tooltip' => 'Nome tecnico del campo associato',
            'helper_text' => 'Nome del campo nel database o nel form associato a questo criterio',
            'help' => 'Nome tecnico del campo collegato al criterio',
        ],
        'anno' => [
            'label' => 'anno',
        ],
        'pos' => [
            'label' => 'Posizione',
            'placeholder' => 'Inserisci la posizione',
            'tooltip' => 'Posizione ordinale del criterio',
            'helper_text' => 'Numero che determina l\'ordine di visualizzazione di questo criterio nella scheda',
            'help' => 'Posizione ordinale per l\'ordinamento dei criteri',
            'description' => 'pos',
        ],
        'converted_in' => [
            'label' => 'Modalità Conversione',
            'placeholder' => 'Seleziona modalità conversione',
            'tooltip' => 'Come viene convertito il punteggio',
            'helper_text' => 'Modalità di conversione del punteggio assegnato al criterio',
            'help' => 'Specifica come il punteggio viene convertito o normalizzato',
            'description' => 'converted_in',
        ],
        'punteggio_minimo' => [
            'label' => 'Punteggio Minimo',
            'placeholder' => 'Inserisci il punteggio minimo',
            'help' => 'Punteggio minimo richiesto per superare la valutazione',
        ],
        'punteggio_massimo' => [
            'label' => 'Punteggio Massimo',
            'placeholder' => 'Inserisci il punteggio massimo',
            'help' => 'Punteggio massimo ottenibile con questa scheda',
        ],
        'modalita_calcolo' => [
            'label' => 'Modalità di Calcolo',
            'placeholder' => 'Seleziona la modalità di calcolo',
            'help' => 'Modalità utilizzata per calcolare il punteggio finale',
            'options' => [
                'somma_pesata' => 'Somma Pesata',
                'media_pesata' => 'Media Pesata',
                'prodotto' => 'Prodotto',
                'personalizzata' => 'Personalizzata',
            ],
        ],
        'formula_calcolo' => [
            'label' => 'Formula di Calcolo',
            'placeholder' => 'Inserisci la formula di calcolo',
            'help' => 'Formula matematica utilizzata per il calcolo del punteggio',
        ],
        'note' => [
            'label' => 'Note',
            'placeholder' => 'Inserisci eventuali note',
            'help' => 'Note aggiuntive o istruzioni per l\'utilizzo della scheda',
        ],
        'istruzioni' => [
            'label' => 'Istruzioni',
            'placeholder' => 'Inserisci le istruzioni',
            'help' => 'Istruzioni dettagliate per l\'utilizzo della scheda criteri',
        ],
        'allegati' => [
            'label' => 'Allegati',
            'placeholder' => 'Seleziona gli allegati',
            'help' => 'Documenti o file allegati alla scheda criteri',
        ],
        'created_at' => [
            'label' => 'Creato il',
            'placeholder' => 'Data di creazione',
            'help' => 'Data e ora di creazione della scheda criteri',
            'helper_text' => 'created_at',
            'description' => 'created_at',
        ],
        'updated_at' => [
            'label' => 'Aggiornato il',
            'placeholder' => 'Data di aggiornamento',
            'help' => 'Data e ora dell\'ultimo aggiornamento',
            'helper_text' => 'updated_at',
            'description' => 'updated_at',
        ],
        'created_by' => [
            'label' => 'Creato da',
            'placeholder' => 'Utente che ha creato',
            'help' => 'Utente che ha creato la scheda criteri',
        ],
        'updated_by' => [
            'label' => 'Aggiornato da',
            'placeholder' => 'Utente che ha aggiornato',
            'help' => 'Utente che ha effettuato l\'ultimo aggiornamento',
        ],
        'parent' => [
            'label' => 'Scheda Padre',
            'placeholder' => 'Seleziona la scheda padre',
            'help' => 'Scheda criteri di livello superiore nella gerarchia',
        ],
        'parent_name' => [
            'label' => 'Nome Scheda Padre',
            'placeholder' => 'Nome della scheda padre',
            'help' => 'Nome della scheda criteri di livello superiore',
        ],
        'assets' => [
            'label' => 'Risorse Associate',
            'placeholder' => 'Seleziona le risorse',
            'help' => 'Documenti o risorse collegate a questa scheda criteri',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
        ],
        'toggleColumns' => [
            'label' => 'toggleColumns',
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
        'value' => [
            'label' => 'value',
            'placeholder' => 'value',
            'helper_text' => 'value',
            'description' => 'value',
        ],
        'openFilters' => [
            'label' => 'openFilters',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
        ],
        'gg_asz_cateco_posfun_fuori_sede' => [
            'description' => 'gg_asz_cateco_posfun_fuori_sede',
            'helper_text' => 'gg_asz_cateco_posfun_fuori_sede',
            'placeholder' => 'gg_asz_cateco_posfun_fuori_sede',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Nuova Scheda Criteri',
            'success' => 'Scheda criteri creata con successo',
            'error' => 'Errore durante la creazione della scheda criteri',
            'confirmation' => 'Sei sicuro di voler creare questa scheda criteri?',
            'icon' => 'create',
            'tooltip' => 'create',
        ],
        'edit' => [
            'label' => 'Modifica Scheda Criteri',
            'success' => 'Scheda criteri aggiornata con successo',
            'error' => 'Errore durante l\'aggiornamento della scheda criteri',
            'confirmation' => 'Sei sicuro di voler modificare questa scheda criteri?',
            'icon' => 'edit',
            'tooltip' => 'edit',
        ],
        'delete' => [
            'label' => 'Elimina Scheda Criteri',
            'success' => 'Scheda criteri eliminata con successo',
            'error' => 'Errore durante l\'eliminazione della scheda criteri',
            'confirmation' => 'Sei sicuro di voler eliminare questa scheda criteri? Questa azione è irreversibile.',
            'tooltip' => 'delete',
            'icon' => 'delete',
        ],
        'view' => [
            'label' => 'Visualizza Scheda Criteri',
            'success' => 'Dettagli scheda criteri caricati',
            'error' => 'Errore durante il caricamento dei dettagli',
            'icon' => 'view',
            'tooltip' => 'view',
        ],
        'duplicate' => [
            'label' => 'Duplica Scheda Criteri',
            'success' => 'Scheda criteri duplicata con successo',
            'error' => 'Errore durante la duplicazione della scheda criteri',
            'confirmation' => 'Sei sicuro di voler duplicare questa scheda criteri?',
        ],
        'activate' => [
            'label' => 'Attiva Scheda Criteri',
            'success' => 'Scheda criteri attivata con successo',
            'error' => 'Errore durante l\'attivazione della scheda criteri',
            'confirmation' => 'Sei sicuro di voler attivare questa scheda criteri?',
        ],
        'deactivate' => [
            'label' => 'Disattiva Scheda Criteri',
            'success' => 'Scheda criteri disattivata con successo',
            'error' => 'Errore durante la disattivazione della scheda criteri',
            'confirmation' => 'Sei sicuro di voler disattivare questa scheda criteri?',
        ],
        'approve' => [
            'label' => 'Approva Scheda Criteri',
            'success' => 'Scheda criteri approvata con successo',
            'error' => 'Errore durante l\'approvazione della scheda criteri',
            'confirmation' => 'Sei sicuro di voler approvare questa scheda criteri?',
        ],
        'reject' => [
            'label' => 'Rifiuta Scheda Criteri',
            'success' => 'Scheda criteri rifiutata con successo',
            'error' => 'Errore durante il rifiuto della scheda criteri',
            'confirmation' => 'Sei sicuro di voler rifiutare questa scheda criteri?',
        ],
        'archive' => [
            'label' => 'Archivia Scheda Criteri',
            'success' => 'Scheda criteri archiviata con successo',
            'error' => 'Errore durante l\'archiviazione della scheda criteri',
            'confirmation' => 'Sei sicuro di voler archiviare questa scheda criteri?',
        ],
        'restore' => [
            'label' => 'Ripristina Scheda Criteri',
            'success' => 'Scheda criteri ripristinata con successo',
            'error' => 'Errore durante il ripristino della scheda criteri',
            'confirmation' => 'Sei sicuro di voler ripristinare questa scheda criteri?',
        ],
        'validate' => [
            'label' => 'Valida Scheda Criteri',
            'success' => 'Scheda criteri validata con successo',
            'error' => 'Errore durante la validazione della scheda criteri',
            'confirmation' => 'Vuoi validare questa scheda criteri?',
        ],
        'test' => [
            'label' => 'Testa Scheda Criteri',
            'success' => 'Test scheda criteri completato con successo',
            'error' => 'Errore durante il test della scheda criteri',
            'confirmation' => 'Vuoi testare questa scheda criteri?',
        ],
        'import' => [
            'label' => 'Importa Scheda Criteri',
            'success' => 'Importazione schede criteri completata con successo',
            'error' => 'Errore durante l\'importazione delle schede criteri',
            'confirmation' => 'Sei sicuro di voler importare le schede criteri dal file selezionato?',
            'fields' => [
                'file' => [
                    'label' => 'File da importare',
                    'placeholder' => 'Seleziona un file XLS o CSV',
                    'help' => 'Formati supportati: XLS, XLSX, CSV. Dimensione massima: 10MB',
                ],
            ],
        ],
        'export' => [
            'label' => 'Esporta Scheda Criteri',
            'success' => 'Esportazione schede criteri completata con successo',
            'error' => 'Errore durante l\'esportazione delle schede criteri',
            'filename_prefix' => 'Scheda_Criteri_',
        ],
        'bulk_delete' => [
            'label' => 'Elimina Selezionate',
            'success' => 'Scheda criteri eliminate con successo',
            'error' => 'Errore durante l\'eliminazione delle schede criteri',
            'confirmation' => 'Sei sicuro di voler eliminare le schede criteri selezionate? Questa azione è irreversibile.',
        ],
        'bulk_activate' => [
            'label' => 'Attiva Selezionate',
            'success' => 'Scheda criteri attivate con successo',
            'error' => 'Errore durante l\'attivazione delle schede criteri',
            'confirmation' => 'Sei sicuro di voler attivare le schede criteri selezionate?',
        ],
        'bulk_approve' => [
            'label' => 'Approva Selezionate',
            'success' => 'Scheda criteri approvate con successo',
            'error' => 'Errore durante l\'approvazione delle schede criteri',
            'confirmation' => 'Sei sicuro di voler approvare le schede criteri selezionate?',
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
        'cancel' => [
            'tooltip' => 'cancel',
            'icon' => 'cancel',
            'label' => 'cancel',
        ],
        'openColumnManager' => [
            'tooltip' => 'openColumnManager',
            'icon' => 'openColumnManager',
            'label' => 'openColumnManager',
        ],
        'save' => [
            'tooltip' => 'save',
            'icon' => 'save',
            'label' => 'save',
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
        'resetColumnManager' => [
            'tooltip' => 'resetColumnManager',
            'icon' => 'resetColumnManager',
            'label' => 'resetColumnManager',
        ],
        'removeAllFilters' => [
            'tooltip' => 'removeAllFilters',
            'label' => 'removeAllFilters',
            'icon' => 'removeAllFilters',
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
    ],
    'messages' => [
        'welcome' => 'Benvenuto nella gestione delle schede criteri',
        'no_data' => 'Nessuna scheda criteri trovata per i criteri selezionati',
        'loading' => 'Caricamento schede criteri in corso...',
        'validating' => 'Validazione in corso...',
        'testing' => 'Test in corso...',
        'search_placeholder' => 'Cerca per nome, codice o descrizione...',
        'filter_by_type' => 'Filtra per tipo',
        'filter_by_status' => 'Filtra per stato',
        'filter_by_year' => 'Filtra per anno',
        'clear_filters' => 'Pulisci filtri',
        'apply_filters' => 'Applica filtri',
        'results_count' => 'Trovate :count schede criteri',
        'selected_count' => ':count elementi selezionati',
        'validation_passed' => 'Validazione superata',
        'validation_failed' => 'Validazione fallita',
        'test_passed' => 'Test superato',
        'test_failed' => 'Test fallito',
        'criteria_count' => ':count criteri configurati',
        'total_weight' => 'Peso totale: :weight',
    ],
    'validation' => [
        'name' => [
            'required' => 'Il nome della scheda criteri è obbligatorio',
            'string' => 'Il nome deve essere una stringa',
            'max' => 'Il nome non può superare :max caratteri',
            'unique' => 'Il nome della scheda criteri è già presente',
        ],
        'codice' => [
            'required' => 'Il codice è obbligatorio',
            'string' => 'Il codice deve essere una stringa',
            'max' => 'Il codice non può superare :max caratteri',
            'unique' => 'Il codice deve essere unico',
            'alpha_num' => 'Il codice può contenere solo lettere e numeri',
        ],
        'tipo' => [
            'required' => 'Il tipo è obbligatorio',
            'in' => 'Il tipo selezionato non è valido',
        ],
        'stato' => [
            'required' => 'Lo stato è obbligatorio',
            'in' => 'Lo stato selezionato non è valido',
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
        'valutatore_id' => [
            'required' => 'Il valutatore è obbligatorio',
            'exists' => 'Il valutatore selezionato non è valido',
            'numeric' => 'L\'ID del valutatore deve essere un numero',
        ],
        'ente' => [
            'required' => 'L\'ente è obbligatorio',
            'exists' => 'L\'ente selezionato non è valido',
        ],
        'stabilimento' => [
            'required' => 'Lo stabilimento è obbligatorio',
            'exists' => 'Lo stabilimento selezionato non è valido',
        ],
        'reparto' => [
            'required' => 'Il reparto è obbligatorio',
            'exists' => 'Il reparto selezionato non è valido',
        ],
        'criteri' => [
            'required' => 'Almeno un criterio è obbligatorio',
            'array' => 'I criteri devono essere un array',
            'min' => 'Deve essere selezionato almeno :min criterio',
        ],
        'peso_totale' => [
            'numeric' => 'Il peso totale deve essere numerico',
            'min' => 'Il peso totale deve essere almeno :min',
            'max' => 'Il peso totale non può essere maggiore di :max',
            'equals_100' => 'Il peso totale deve essere esattamente 100',
        ],
        'punteggio_minimo' => [
            'numeric' => 'Il punteggio minimo deve essere numerico',
            'min' => 'Il punteggio minimo deve essere almeno :min',
            'lte' => 'Il punteggio minimo deve essere minore o uguale al punteggio massimo',
        ],
        'punteggio_massimo' => [
            'numeric' => 'Il punteggio massimo deve essere numerico',
            'min' => 'Il punteggio massimo deve essere almeno :min',
            'gte' => 'Il punteggio massimo deve essere maggiore o uguale al punteggio minimo',
        ],
        'versione' => [
            'required' => 'La versione è obbligatoria',
            'numeric' => 'La versione deve essere numerica',
            'min' => 'La versione deve essere almeno :min',
        ],
        'modalita_calcolo' => [
            'required' => 'La modalità di calcolo è obbligatoria',
            'in' => 'La modalità di calcolo selezionata non è valida',
        ],
        'formula_calcolo' => [
            'required_if' => 'La formula di calcolo è obbligatoria per modalità personalizzata',
            'string' => 'La formula di calcolo deve essere una stringa',
            'max' => 'La formula di calcolo non può superare :max caratteri',
        ],
    ],
    'filters' => [
        'type' => [
            'label' => 'Tipo',
            'placeholder' => 'Seleziona tipo',
            'all' => 'Tutti i tipi',
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
        'evaluator' => [
            'label' => 'Valutatore',
            'placeholder' => 'Seleziona valutatore',
            'all' => 'Tutti i valutatori',
        ],
        'entity' => [
            'label' => 'Ente',
            'placeholder' => 'Seleziona ente',
            'all' => 'Tutti gli enti',
        ],
    ],
    'tabs' => [
        'general' => [
            'label' => 'Informazioni Generali',
            'description' => 'Dati principali della scheda criteri',
        ],
        'criteria' => [
            'label' => 'Criteri',
            'description' => 'Criteri di valutazione e pesi',
        ],
        'calculation' => [
            'label' => 'Calcolo',
            'description' => 'Modalità e formula di calcolo',
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
    'model' => [
        'label' => 'Modello Scheda Criteri',
        'placeholder' => 'Seleziona modello scheda criteri',
        'tooltip' => 'Modello dati per le schede dei criteri',
        'helper_text' => 'Rappresentazione del modello dati utilizzato per gestire le schede contenenti i criteri di valutazione',
        'help' => 'Modello che definisce la struttura dati per le schede dei criteri',
    ],
    'label' => 'scheda criteri',
];
