<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Scheda',
        'plural' => 'Scheda',
        'group' => [
            'name' => 'Scheda',
            'description' => 'Gestione delle schede di valutazione',
        ],
        'sort' => 1,
        'icon' => 'heroicon-o-document-text',
        'label' => 'Scheda',
    ],
    'actions' => [
        'import' => [
            'label' => 'Importa da file',
            'success' => 'File importato con successo',
            'error' => 'Errore durante l\'importazione del file',
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
            'filename_prefix' => 'Scheda_',
            'columns' => [
                'name' => [
                    'label' => 'Nome scheda',
                    'help' => 'Nome identificativo della scheda',
                ],
                'parent_name' => [
                    'label' => 'Nome scheda padre',
                    'help' => 'Nome della scheda di livello superiore',
                ],
            ],
        ],
        'create' => [
            'label' => 'Nuova scheda',
            'success' => 'Scheda creata con successo',
            'error' => 'Errore durante la creazione della scheda',
            'tooltip' => 'create',
            'icon' => 'create',
        ],
        'edit' => [
            'label' => 'Modifica scheda',
            'success' => 'Scheda aggiornata con successo',
            'error' => 'Errore durante l\'aggiornamento della scheda',
        ],
        'delete' => [
            'label' => 'Elimina scheda',
            'success' => 'Scheda eliminata con successo',
            'error' => 'Errore durante l\'eliminazione della scheda',
            'confirmation' => 'Sei sicuro di voler eliminare questa scheda? Questa azione è irreversibile.',
        ],
        'view' => [
            'label' => 'Visualizza scheda',
        ],
        'logout' => [
            'icon' => 'logout',
            'tooltip' => 'logout',
            'label' => 'logout',
        ],
        'reorderRecords' => [
            'icon' => 'reorderRecords',
            'tooltip' => 'reorderRecords',
            'label' => 'reorderRecords',
        ],
        'send_schede' => [
            'tooltip' => 'send_schede',
            'icon' => 'send_schede',
            'label' => 'send_schede',
        ],
        'profile' => [
            'tooltip' => 'profile',
            'icon' => 'profile',
            'label' => 'profile',
        ],
        'openColumnManager' => [
            'tooltip' => 'openColumnManager',
            'icon' => 'openColumnManager',
            'label' => 'openColumnManager',
        ],
        'applyTableColumnManager' => [
            'tooltip' => 'applyTableColumnManager',
            'icon' => 'applyTableColumnManager',
            'label' => 'applyTableColumnManager',
        ],
        'pdf' => [
            'tooltip' => 'pdf',
            'icon' => 'pdf',
            'label' => 'pdf',
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
        'compila' => [
            'tooltip' => 'compila',
            'icon' => 'compila',
            'label' => 'compila',
        ],
        'layout' => [
            'tooltip' => 'layout',
            'icon' => 'layout',
            'label' => 'layout',
        ],
        'ricalcola' => [
            'tooltip' => 'ricalcola',
            'icon' => 'ricalcola',
            'label' => 'ricalcola',
        ],
        'MakePdfAction' => [
            'tooltip' => 'MakePdfAction',
            'icon' => 'MakePdfAction',
            'label' => 'MakePdfAction',
        ],
        'cancel' => [
            'tooltip' => 'cancel',
            'icon' => 'cancel',
        ],
    ],
    'tab' => [
        'index' => [
            'label' => 'Lista',
            'help' => 'Visualizza tutte le schede',
        ],
        'create' => [
            'label' => 'Aggiungi',
            'help' => 'Crea una nuova scheda',
        ],
    ],
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome della scheda',
            'help' => 'Nome identificativo della scheda di valutazione',
        ],
        'parent' => [
            'label' => 'Scheda Padre',
            'placeholder' => 'Seleziona la scheda padre',
            'help' => 'Scheda di livello superiore nella gerarchia',
        ],
        'parent_name' => [
            'label' => 'Nome Scheda Padre',
            'help' => 'Nome della scheda di livello superiore',
        ],
        'assets' => [
            'label' => 'Risorse',
            'help' => 'Risorse associate alla scheda',
        ],
        'id' => [
            'label' => 'ID',
            'help' => 'Identificativo univoco della scheda',
        ],
        'cognome' => [
            'label' => 'Cognome',
            'placeholder' => 'Inserisci il cognome del dipendente',
            'help' => 'Cognome del dipendente valutato',
            'description' => 'cognome',
            'helper_text' => 'cognome',
        ],
        'nome' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome del dipendente',
            'help' => 'Nome del dipendente valutato',
        ],
        'ente' => [
            'label' => 'Ente',
            'placeholder' => 'Seleziona l\'ente di appartenenza',
            'help' => 'Ente di appartenenza del dipendente',
        ],
        'matr' => [
            'label' => 'Matricola',
            'placeholder' => 'Inserisci la matricola del dipendente',
            'help' => 'Numero di matricola del dipendente',
            'description' => 'matr',
            'helper_text' => 'matr',
        ],
        'stabi' => [
            'label' => 'Stabilimento',
            'placeholder' => 'Seleziona lo stabilimento di appartenenza',
            'help' => 'Stabilimento di appartenenza del dipendente',
        ],
        'stabi_txt' => [
            'label' => 'Testo Stabilimento',
            'help' => 'Descrizione testuale dello stabilimento',
        ],
        'repar' => [
            'label' => 'Reparto',
            'placeholder' => 'Seleziona il reparto di appartenenza',
            'help' => 'Reparto di appartenenza del dipendente',
        ],
        'repar_txt' => [
            'label' => 'Testo Reparto',
            'help' => 'Descrizione testuale del reparto',
        ],
        'rep2kd' => [
            'label' => 'Rep2KD',
            'help' => 'Codice reparto 2KD',
        ],
        'rep2ka' => [
            'label' => 'Rep2KA',
            'help' => 'Codice reparto 2KA',
        ],
        'propro' => [
            'label' => 'ProPro',
            'help' => 'Codice progressione professionale',
        ],
        'posfun' => [
            'label' => 'PosFun',
            'help' => 'Posizione funzionale del dipendente',
        ],
        'qua2kd' => [
            'label' => 'Qua2KD',
            'help' => 'Qualifica 2KD del dipendente',
        ],
        'qua2ka' => [
            'label' => 'Qua2KA',
            'help' => 'Qualifica 2KA del dipendente',
        ],
        'categoria_eco' => [
            'label' => 'Categoria Economica',
            'help' => 'Categoria economica del dipendente',
        ],
        'anno' => [
            'label' => 'Anno',
            'placeholder' => 'Inserisci l\'anno di riferimento',
            'help' => 'Anno di riferimento per la valutazione',
            'description' => 'anno',
            'helper_text' => 'anno',
        ],
        'ha_diritto' => [
            'label' => 'Ha Diritto',
            'help' => 'Indica se il dipendente ha diritto alla progressione',
        ],
        'motivo' => [
            'label' => 'Motivo',
            'placeholder' => 'Inserisci il motivo della valutazione',
            'help' => 'Motivo della valutazione o progressione',
        ],
        'valutatore_id' => [
            'label' => 'Valutatore',
            'placeholder' => 'Seleziona il valutatore',
            'help' => 'Valutatore assegnato per la scheda',
            'description' => 'valutatore_id',
            'helper_text' => 'valutatore_id',
        ],
        'anno_valutatore' => [
            'label' => 'Anno/Valutatore',
            'help' => 'Anno e valutatore associati',
        ],
        'al' => [
            'label' => 'Data Fine',
            'placeholder' => 'Seleziona la data di fine',
            'help' => 'Data di fine del periodo di valutazione',
        ],
        'dal' => [
            'label' => 'Data Inizio',
            'placeholder' => 'Seleziona la data di inizio',
            'help' => 'Data di inizio del periodo di valutazione',
        ],
        'periodo' => [
            'label' => 'Periodo',
            'help' => 'Periodo di riferimento per la valutazione',
        ],
        'rep' => [
            'label' => 'Reparto',
            'help' => 'Reparto di appartenenza',
        ],
        'mail_sended_at' => [
            'label' => 'Mail inviata il',
            'help' => 'Data e ora di invio della mail di notifica',
        ],
        'lavoratore' => [
            'label' => 'Lavoratore',
            'help' => 'Lavoratore associato alla scheda',
        ],
        'email' => [
            'label' => 'E-mail',
            'placeholder' => 'es: marco@example.com',
            'help' => 'Indirizzo email del dipendente',
        ],
        'full_name' => [
            'label' => 'Nome Completo',
            'placeholder' => 'Nome e cognome',
            'tooltip' => 'Nome completo del dipendente',
            'helper_text' => 'Nome e cognome del dipendente concatenati',
            'help' => 'Nome completo formato da cognome e nome',
        ],
        'punt_progressione' => [
            'label' => 'Punteggio Progressione',
            'placeholder' => 'Inserisci punteggio',
            'tooltip' => 'Punteggio assegnato per la progressione',
            'helper_text' => 'Punteggio numerico assegnato al dipendente per la progressione',
            'help' => 'Punteggio finale della valutazione per la progressione',
        ],
        'totale' => [
            'label' => 'Totale',
            'placeholder' => 'Totale calcolato',
            'tooltip' => 'Punteggio totale',
            'helper_text' => 'Punteggio totale calcolato dalla somma di tutti i criteri',
            'help' => 'Punteggio totale finale della valutazione',
        ],
        'excellences_count_last_3_years' => [
            'label' => 'Eccellenze Ultimi 3 Anni',
            'placeholder' => 'Numero eccellenze',
            'tooltip' => 'Numero di eccellenze negli ultimi 3 anni',
            'helper_text' => 'Conteggio delle valutazioni di eccellenza ottenute negli ultimi 3 anni',
            'help' => 'Numero di eccellenze conseguite negli ultimi 3 anni',
        ],
        'perf_ind_media' => [
            'label' => 'Media Performance Individuale',
            'placeholder' => 'Media performance',
            'tooltip' => 'Media delle performance individuali',
            'helper_text' => 'Media calcolata delle performance individuali del dipendente',
            'help' => 'Media delle valutazioni di performance individuale',
        ],
        'gg_cateco_posfun_no_asz' => [
            'label' => 'Giorni Categoria Posizione Senza Assenze',
            'placeholder' => 'Giorni lavorativi',
            'tooltip' => 'Giorni lavorativi nella categoria e posizione senza assenze',
            'helper_text' => 'Numero di giorni lavorativi nella categoria economica e posizione funzionale senza assenze',
            'help' => 'Giorni di servizio nella categoria e posizione senza assenze',
        ],
        'gg_integ_params' => [
            'label' => 'Giorni Parametri Integrativi',
            'placeholder' => 'Giorni parametri integrativi',
            'tooltip' => 'Giorni con parametri integrativi',
            'helper_text' => 'Numero di giorni con parametri integrativi applicati',
            'help' => 'Giorni di servizio con parametri integrativi',
        ],
        'gg_esperienza_no_asz' => [
            'label' => 'Giorni Esperienza Senza Assenze',
            'placeholder' => 'Giorni esperienza senza assenze',
            'tooltip' => 'Giorni di esperienza senza assenze',
            'helper_text' => 'Numero di giorni di esperienza calcolati senza assenze (gg_integ_params se presente, altrimenti gg_cateco_posfun_no_asz)',
            'help' => 'Giorni di esperienza effettivi senza assenze per la valutazione',
        ],
        'gg_in_sede' => [
            'label' => 'Giorni in Sede',
            'placeholder' => 'Giorni in sede',
            'tooltip' => 'Giorni lavorativi in sede',
            'helper_text' => 'Numero di giorni lavorativi prestati presso la sede di servizio',
            'help' => 'Giorni di lavoro effettuati in sede',
        ],
        'eta' => [
            'label' => 'Età',
            'help' => 'Età del dipendente al momento della valutazione',
        ],
        'criteri' => [
            'label' => 'Criteri',
            'help' => 'Criteri di valutazione per la scheda',
        ],
        'gg' => [
            'label' => 'Giorni',
            'help' => 'Numero totale di giorni considerati',
        ],
        'gg_no_asz' => [
            'label' => 'Giorni senza ASZ',
            'help' => 'Giorni lavorati senza ASZ (Assenza per Servizio di Zona)',
        ],
        'gg_asz' => [
            'label' => 'Giorni con ASZ',
            'help' => 'Giorni lavorati con ASZ (Assenza per Servizio di Zona)',
        ],
        'gg_cateco_no_posfun_no_asz' => [
            'label' => 'Giorni Cateco senza PosFun/ASZ',
            'help' => 'Giorni in categoria economica senza posizione funzionale e senza ASZ',
        ],
        'qua' => [
            'label' => 'Qualifica',
            'help' => 'Qualifica attuale del dipendente',
        ],
        'categoria_ecoval' => [
            'label' => 'Categoria EcoVal',
            'help' => 'Categoria economica valutata',
        ],
        'posfunval' => [
            'label' => 'PosFunVal',
            'help' => 'Posizione Funzionale Valutata',
        ],
        'posiz' => [
            'label' => 'Posizione',
            'help' => 'Posizione attuale del dipendente',
        ],
        'posiz_txt' => [
            'label' => 'Testo Posizione',
            'help' => 'Descrizione testuale della posizione',
        ],
        'disci1' => [
            'label' => 'Disciplina 1',
            'help' => 'Prima disciplina di riferimento',
        ],
        'disci1_txt' => [
            'label' => 'Testo Disciplina 1',
            'help' => 'Descrizione testuale della disciplina',
        ],
        'applyFilters' => [
            'label' => 'Applica Filtri',
            'help' => 'Applica i filtri selezionati',
        ],
        'id_placeholder' => ' ',
        'cognome_placeholder' => ' ',
        'nome_placeholder' => ' ',
        'motivo_placeholder' => ' ',
        'create' => [
            'label' => 'create',
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
        'pdf' => [
            'label' => 'pdf',
        ],
        'compila' => [
            'label' => 'compila',
        ],
        'layout' => [
            'label' => 'layout',
        ],
        'anno/valutatore' => [
            'label' => 'anno/valutatore',
        ],
    ],
    'schede' => [
        'field' => [
            'stabi' => 'Stabilimento',
            'valutatore_id' => 'Valutatore',
            'valutatore_id_placeholder' => 'Seleziona il valutatore',
            'year' => 'Anno',
            'year_placeholder' => 'anno es 2019',
            'sort_by_placeholder' => 'Ordina per',
            'sort_order_placeholder' => 'Ordine',
        ],
    ],
    'messages' => [
        'welcome' => 'Benvenuto nel modulo Scheda',
        'no_data' => 'Nessuna scheda trovata',
        'loading' => 'Caricamento in corso...',
        'error' => 'Si è verificato un errore',
        'success' => 'Operazione completata con successo',
    ],
    'validation' => [
        'name_required' => 'Il nome della scheda è obbligatorio',
        'anno_required' => 'L\'anno è obbligatorio',
        'anno_numeric' => 'L\'anno deve essere un numero',
        'anno_min' => 'L\'anno deve essere almeno :min',
        'anno_max' => 'L\'anno non può essere maggiore di :max',
        'email_email' => 'L\'email deve essere un indirizzo valido',
        'matr_unique' => 'La matricola deve essere unica',
    ],
    'model' => [
        'label' => 'Modello Scheda',
        'placeholder' => 'Seleziona modello schede',
        'tooltip' => 'Modello dati per le schede di valutazione',
        'helper_text' => 'Rappresentazione del modello dati utilizzato per gestire le schede di valutazione e documentazione',
        'help' => 'Modello che definisce la struttura dati per le schede di valutazione',
    ],
    'label' => 'schede',
];
