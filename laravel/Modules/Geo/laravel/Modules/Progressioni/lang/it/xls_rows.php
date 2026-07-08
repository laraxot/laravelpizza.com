<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Righe XLS',
        'plural' => 'Righe XLS',
        'group' => [
            'name' => 'Gestione Progressioni',
            'description' => 'Gestione completa delle progressioni di carriera',
        ],
        'sort' => 17,
        'icon' => 'heroicon-o-table-cells',
        'label' => 'Righe XLS',
    ],
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'help' => 'Nome identificativo della riga XLS',
        ],
        'parent' => [
            'label' => 'Padre',
            'placeholder' => 'Seleziona l\'elemento padre',
            'help' => 'Elemento di livello superiore nella gerarchia',
        ],
        'parent_name' => [
            'label' => 'Padre',
            'placeholder' => 'Nome dell\'elemento padre',
            'help' => 'Nome dell\'elemento di livello superiore',
        ],
        'assets' => [
            'label' => 'Risorse',
            'placeholder' => 'Seleziona le risorse',
            'help' => 'Risorse associate alla riga XLS',
        ],
        'id' => [
            'label' => 'ID',
            'placeholder' => 'ID univoco',
            'help' => 'Identificativo univoco della riga',
        ],
        'ente' => [
            'label' => 'Ente',
            'placeholder' => 'Seleziona l\'ente',
            'help' => 'Ente di appartenenza',
        ],
        'matr' => [
            'label' => 'Matricola',
            'placeholder' => 'Inserisci la matricola',
            'help' => 'Matricola del dipendente',
        ],
        'cognome' => [
            'label' => 'Cognome',
            'placeholder' => 'Inserisci il cognome',
            'help' => 'Cognome del dipendente',
        ],
        'nome' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'help' => 'Nome del dipendente',
        ],
        'ptime' => [
            'label' => 'Part-time',
            'placeholder' => 'Indica se part-time',
            'help' => 'Indica se il dipendente lavora part-time',
        ],
        'valore_differenziale_rapportato_pt' => [
            'label' => 'Valore Differenziale Rapportato PT',
            'placeholder' => 'Inserisci il valore',
            'help' => 'Valore differenziale rapportato a tempo parziale',
        ],
        'categoria_eco' => [
            'label' => 'Posizione Economica',
            'placeholder' => 'Seleziona la posizione economica',
            'help' => 'Posizione economica del dipendente',
        ],
        'categoria_ecoval' => [
            'label' => 'Categoria Giuridica',
            'placeholder' => 'Seleziona la categoria giuridica',
            'help' => 'Categoria giuridica del dipendente',
        ],
        'excellences_count_last_3_years' => [
            'label' => 'Eccellenze (Ultimi 3 Anni)',
            'placeholder' => 'Numero di eccellenze',
            'help' => 'Numero di eccellenze ottenute negli ultimi 3 anni',
        ],
        'gg_cateco_posfun_no_asz' => [
            'label' => 'Esperienza nella Posizione Economica',
            'placeholder' => 'Giorni di esperienza',
            'help' => 'Giorni di esperienza nella posizione economica senza assenze',
        ],
        'perf_ind_media' => [
            'label' => 'Valutazione Media Performance',
            'placeholder' => 'Punteggio medio',
            'help' => 'Valutazione media della performance individuale',
        ],
        'punt_progressione' => [
            'label' => 'Conoscenza Valutazione Dirigente',
            'placeholder' => 'Punteggio valutazione',
            'help' => 'Punteggio della conoscenza e valutazione del dirigente',
        ],
        'punt_progressione_finale' => [
            'label' => 'Punteggio Totale',
            'placeholder' => 'Punteggio finale',
            'help' => 'Punteggio totale per la progressione',
        ],
        'benificiario_progressione' => [
            'label' => 'Beneficiario Progressione',
            'placeholder' => 'Indica se beneficiario',
            'help' => 'Indica se il dipendente è beneficiario della progressione',
        ],
        'gg_cateco_posfun' => [
            'label' => 'Giorni Anzianità Posizione Economica',
            'placeholder' => 'Giorni di anzianità',
            'help' => 'Giorni di anzianità nella posizione economica',
        ],
        'gg_in_sede_no_asz' => [
            'label' => 'Anzianità di Servizio presso l\'Ente',
            'placeholder' => 'Giorni di servizio',
            'help' => 'Giorni di anzianità di servizio presso l\'Ente senza assenze',
        ],
        'eta' => [
            'label' => 'Età',
            'placeholder' => 'Età del dipendente',
            'help' => 'Età anagrafica del dipendente',
        ],
        'gg_cateco_posfun_in_sede_no_asz' => [
            'label' => 'Giorni Categoria/Posizione in Sede',
            'placeholder' => 'Giorni in sede',
            'help' => 'Giorni di categoria/posizione funzionale in sede senza assenze',
        ],
    ],
    'actions' => [
        'import' => [
            'label' => 'Importa da file',
            'success' => 'File importato con successo',
            'error' => 'Errore durante l\'importazione del file',
            'confirmation' => 'Sei sicuro di voler importare i dati dal file selezionato?',
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
            'confirmation' => 'Sei sicuro di voler esportare i dati?',
            'filename_prefix' => 'Righe_XLS_',
            'columns' => [
                'name' => [
                    'label' => 'Nome riga',
                    'help' => 'Nome della riga XLS',
                ],
                'parent_name' => [
                    'label' => 'Nome elemento padre',
                    'help' => 'Nome dell\'elemento di livello superiore',
                ],
            ],
        ],
        'create' => [
            'label' => 'Nuova Riga XLS',
            'success' => 'Riga XLS creata con successo',
            'error' => 'Errore durante la creazione della riga XLS',
            'confirmation' => 'Sei sicuro di voler creare questa riga XLS?',
        ],
        'edit' => [
            'label' => 'Modifica Riga XLS',
            'success' => 'Riga XLS aggiornata con successo',
            'error' => 'Errore durante l\'aggiornamento della riga XLS',
            'confirmation' => 'Sei sicuro di voler modificare questa riga XLS?',
        ],
        'delete' => [
            'label' => 'Elimina Riga XLS',
            'success' => 'Riga XLS eliminata con successo',
            'error' => 'Errore durante l\'eliminazione della riga XLS',
            'confirmation' => 'Sei sicuro di voler eliminare questa riga XLS? Questa azione è irreversibile.',
        ],
        'view' => [
            'label' => 'Visualizza Riga XLS',
            'success' => 'Dettagli riga XLS caricati',
            'error' => 'Errore durante il caricamento dei dettagli',
        ],
        'bulk_delete' => [
            'label' => 'Elimina Selezionate',
            'success' => 'Righe XLS eliminate con successo',
            'error' => 'Errore durante l\'eliminazione delle righe XLS',
            'confirmation' => 'Sei sicuro di voler eliminare le righe XLS selezionate? Questa azione è irreversibile.',
        ],
    ],
    'messages' => [
        'welcome' => 'Benvenuto nella gestione delle righe XLS',
        'no_data' => 'Nessuna riga XLS trovata per i criteri selezionati',
        'loading' => 'Caricamento righe XLS in corso...',
        'search_placeholder' => 'Cerca per nome, matricola o cognome...',
        'filter_by_entity' => 'Filtra per ente',
        'filter_by_category' => 'Filtra per categoria',
        'clear_filters' => 'Pulisci filtri',
        'apply_filters' => 'Applica filtri',
        'results_count' => 'Trovate :count righe XLS',
        'selected_count' => ':count elementi selezionati',
        'processing_file' => 'Elaborazione file in corso...',
        'file_processed' => 'File elaborato con successo',
        'rows_imported' => ':count righe importate',
        'rows_updated' => ':count righe aggiornate',
        'rows_skipped' => ':count righe saltate',
    ],
    'validation' => [
        'name' => [
            'required' => 'Il nome è obbligatorio',
            'string' => 'Il nome deve essere una stringa',
            'max' => 'Il nome non può superare :max caratteri',
        ],
        'matr' => [
            'required' => 'La matricola è obbligatoria',
            'string' => 'La matricola deve essere una stringa',
            'unique' => 'La matricola deve essere unica',
        ],
        'cognome' => [
            'required' => 'Il cognome è obbligatorio',
            'string' => 'Il cognome deve essere una stringa',
            'max' => 'Il cognome non può superare :max caratteri',
        ],
        'nome_dipendente' => [
            'required' => 'Il nome del dipendente è obbligatorio',
            'string' => 'Il nome deve essere una stringa',
            'max' => 'Il nome non può superare :max caratteri',
        ],
        'eta' => [
            'numeric' => 'L\'età deve essere un numero',
            'min' => 'L\'età deve essere almeno :min anni',
            'max' => 'L\'età non può superare :max anni',
        ],
        'punt_progressione_finale' => [
            'numeric' => 'Il punteggio finale deve essere numerico',
            'min' => 'Il punteggio finale non può essere negativo',
        ],
        'perf_ind_media' => [
            'numeric' => 'La valutazione media deve essere numerica',
            'min' => 'La valutazione media non può essere negativa',
            'max' => 'La valutazione media non può superare :max',
        ],
        'excellences_count_last_3_years' => [
            'numeric' => 'Il numero di eccellenze deve essere numerico',
            'min' => 'Il numero di eccellenze non può essere negativo',
        ],
        'gg_cateco_posfun_no_asz' => [
            'numeric' => 'I giorni di esperienza devono essere numerici',
            'min' => 'I giorni di esperienza non possono essere negativi',
        ],
        'gg_in_sede_no_asz' => [
            'numeric' => 'I giorni di anzianità devono essere numerici',
            'min' => 'I giorni di anzianità non possono essere negativi',
        ],
    ],
    'filters' => [
        'entity' => [
            'label' => 'Ente',
            'placeholder' => 'Seleziona ente',
            'all' => 'Tutti gli enti',
        ],
        'category' => [
            'label' => 'Categoria',
            'placeholder' => 'Seleziona categoria',
            'all' => 'Tutte le categorie',
        ],
        'progression_status' => [
            'label' => 'Stato Progressione',
            'placeholder' => 'Seleziona stato',
            'all' => 'Tutti gli stati',
            'beneficiary' => 'Beneficiario',
            'non_beneficiary' => 'Non beneficiario',
        ],
    ],
    'tabs' => [
        'general' => [
            'label' => 'Informazioni Generali',
            'description' => 'Dati principali della riga XLS',
        ],
        'employee_data' => [
            'label' => 'Dati Dipendente',
            'description' => 'Informazioni anagrafiche e contrattuali',
        ],
        'evaluation' => [
            'label' => 'Valutazione',
            'description' => 'Dati di valutazione e punteggi',
        ],
        'progression' => [
            'label' => 'Progressione',
            'description' => 'Informazioni sulla progressione di carriera',
        ],
        'history' => [
            'label' => 'Storico',
            'description' => 'Cronologia delle modifiche',
        ],
    ],
];
