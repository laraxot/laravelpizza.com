<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Scheda Regionali',
        'plural' => 'Scheda Regionali',
        'group' => [
            'name' => 'Scheda',
            'description' => 'Gestione delle schede di valutazione regionali',
        ],
        'label' => 'Scheda Regionali',
        'sort' => 33,
        'icon' => 'performance-region-document',
    ],
    'fields' => [
        'regione' => [
            'name' => [
                'label' => 'Nome Regione',
                'placeholder' => 'Inserisci il nome della regione',
                'help' => 'Nome della regione di riferimento',
            ],
            'codice' => [
                'label' => 'Codice Regione',
                'placeholder' => 'Inserisci il codice regionale',
                'help' => 'Codice identificativo della regione',
            ],
            'area' => [
                'label' => 'Area Geografica',
                'placeholder' => 'Seleziona l\'area',
                'help' => 'Area geografica di appartenenza',
                'options' => [
                    'nord' => 'Nord',
                    'centro' => 'Centro',
                    'sud' => 'Sud',
                    'isole' => 'Isole',
                ],
            ],
        ],
        'performance' => [
            'totale' => [
                'label' => 'Totale Performance',
                'placeholder' => 'Inserisci il totale',
                'help' => 'Punteggio totale delle performance regionali',
            ],
            'media' => [
                'label' => 'Media Performance',
                'help' => 'Media delle performance degli stabilimenti',
            ],
            'trend' => [
                'label' => 'Trend',
                'help' => 'Andamento rispetto al periodo precedente',
                'options' => [
                    'crescita' => 'In Crescita',
                    'stabile' => 'Stabile',
                    'decrescita' => 'In Decrescita',
                ],
            ],
        ],
        'stabilimenti' => [
            'numero' => [
                'label' => 'Numero Stabilimenti',
                'help' => 'Totale stabilimenti nella regione',
            ],
            'attivi' => [
                'label' => 'Stabilimenti Attivi',
                'help' => 'Numero di stabilimenti operativi',
            ],
            'valutati' => [
                'label' => 'Stabilimenti Valutati',
                'help' => 'Numero di stabilimenti con valutazione completa',
            ],
        ],
        'periodo' => [
            'inizio' => [
                'label' => 'Data Inizio',
                'placeholder' => 'Seleziona la data di inizio',
                'help' => 'Inizio del periodo di valutazione',
            ],
            'fine' => [
                'label' => 'Data Fine',
                'placeholder' => 'Seleziona la data di fine',
                'help' => 'Fine del periodo di valutazione',
            ],
        ],
        'timestamps' => [
            'created_at' => [
                'label' => 'Data Creazione',
                'help' => 'Data di creazione del record',
            ],
            'updated_at' => [
                'label' => 'Ultimo Aggiornamento',
                'help' => 'Data dell\'ultima modifica',
            ],
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
            'label' => 'value',
            'description' => 'value',
            'helper_text' => 'value',
            'placeholder' => 'value',
        ],
        'fill' => [
            'label' => 'fill',
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
        'create' => [
            'label' => 'create',
        ],
        'anno' => [
            'label' => 'anno',
        ],
        'al' => [
            'label' => 'al',
        ],
        'dal' => [
            'label' => 'dal',
        ],
        'repar_txt' => [
            'label' => 'repar_txt',
        ],
        'repar' => [
            'label' => 'repar',
        ],
        'stabi_txt' => [
            'label' => 'stabi_txt',
        ],
        'stabi' => [
            'label' => 'stabi',
        ],
        'posfunval' => [
            'label' => 'posfunval',
        ],
        'categoria_ecoval' => [
            'label' => 'categoria_ecoval',
        ],
        'ha_diritto' => [
            'label' => 'ha_diritto',
        ],
        'motivo' => [
            'label' => 'motivo',
        ],
        'mail_sended_at' => [
            'label' => 'mail_sended_at',
        ],
        'cognome' => [
            'label' => 'cognome',
        ],
        'nome' => [
            'label' => 'nome',
        ],
        'matr' => [
            'label' => 'matr',
        ],
        'email' => [
            'label' => 'email',
        ],
        'totale_punteggio' => [
            'label' => 'totale_punteggio',
        ],
        'propro' => [
            'label' => 'propro',
        ],
        'posfun' => [
            'label' => 'posfun',
        ],
        'categoria_eco' => [
            'label' => 'categoria_eco',
        ],
        'hh_assenza_dalal' => [
            'label' => 'hh_assenza_dalal',
        ],
        'gg_assenza_dalal' => [
            'label' => 'gg_assenza_dalal',
        ],
        'risultati_ottenuti' => 'Conseguimento degli obiettivi',
        'qualita_prestazione' => 'Monitoraggio delle attività afferenti i processi',
        'arricchimento_professionale' => 'Attuazione di strategie di miglioramento del "clima lavorativo"',
        'impegno' => 'Organizzazione della programmazione delle attività',
        'esperienza_acquisita' => 'Focalizzazione dei processi di comunicazione sulla condivisione dei risultati',
        'valutatore_id' => [
            'label' => 'valutatore_id',
        ],
        'pdf' => [
            'label' => 'pdf',
        ],
        'layout' => [
            'label' => 'layout',
        ],
        'anno_valutatore' => [
            'label' => 'anno_valutatore',
        ],
        'motivo/invio_email' => [
            'label' => 'motivo/invio_email',
        ],
        'id' => [
            'label' => 'id',
        ],
        'type' => [
            'label' => 'type',
        ],
        'mail_sended_a1t' => [
            'label' => 'mail_sended_a1t',
        ],
        'id/type/ha_diritto' => [
            'label' => 'id/type/ha_diritto',
        ],
        'id/type/ha_diritto/motivo' => [
            'label' => 'id/type/ha_diritto/motivo',
        ],
        'id/motivo' => [
            'label' => 'id/motivo',
        ],
    ],
    'actions' => [
        'calculate' => [
            'label' => 'Calcola Performance',
            'success' => 'Performance calcolate con successo',
            'error' => 'Errore durante il calcolo delle performance',
        ],
        'export' => [
            'label' => 'Esporta Report',
            'success' => 'Report regionale esportato con successo',
            'error' => 'Errore durante l\'esportazione del report',
        ],
        'compare' => [
            'label' => 'Confronta Regioni',
            'success' => 'Confronto completato con successo',
            'error' => 'Errore durante il confronto',
        ],
        'copy_from_organizzativa' => [
            'label' => 'copy_from_organizzativa',
            'icon' => 'copy_from_organizzativa',
            'tooltip' => 'copy_from_organizzativa',
        ],
        'populate_year' => [
            'label' => 'populate_year',
            'icon' => 'populate_year',
            'tooltip' => 'populate_year',
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
        'MakePdfAction' => [
            'label' => 'MakePdfAction',
            'icon' => 'MakePdfAction',
            'tooltip' => 'MakePdfAction',
        ],
        'compila' => [
            'label' => 'compila',
            'icon' => 'compila',
            'tooltip' => 'compila',
        ],
        'pdf' => [
            'label' => 'pdf',
            'icon' => 'pdf',
            'tooltip' => 'pdf',
        ],
        'send_mail' => [
            'label' => 'send_mail',
            'icon' => 'send_mail',
            'tooltip' => 'send_mail',
        ],
        'zip_schede' => [
            'label' => 'zip_schede',
            'icon' => 'zip_schede',
            'tooltip' => 'zip_schede',
        ],
        'create' => [
            'label' => 'create',
            'icon' => 'create',
            'tooltip' => 'create',
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
        'reorderRecords' => [
            'tooltip' => 'reorderRecords',
            'icon' => 'reorderRecords',
            'label' => 'reorderRecords',
        ],
        'profile' => [
            'tooltip' => 'profile',
            'icon' => 'profile',
            'label' => 'profile',
        ],
        'trova_esclusi' => [
            'label' => 'trova_esclusi',
            'icon' => 'trova_esclusi',
            'tooltip' => 'trova_esclusi',
        ],
        'export_xls' => [
            'label' => 'export_xls',
            'icon' => 'export_xls',
            'tooltip' => 'export_xls',
        ],
        'resetColumnManager' => [
            'tooltip' => 'resetColumnManager',
            'icon' => 'resetColumnManager',
            'label' => 'resetColumnManager',
        ],
        'delete' => [
            'tooltip' => 'delete',
            'icon' => 'delete',
            'label' => 'delete',
        ],
        'edit' => [
            'tooltip' => 'edit',
            'icon' => 'edit',
            'label' => 'edit',
        ],
        'export_pdf' => [
            'label' => 'export_pdf',
            'icon' => 'export_pdf',
            'tooltip' => 'export_pdf',
        ],
        'view' => [
            'label' => 'view',
            'icon' => 'view',
            'tooltip' => 'view',
        ],
    ],
    'messages' => [
        'validation' => [
            'regione' => [
                'required' => 'La regione è obbligatoria',
                'exists' => 'La regione selezionata non esiste',
            ],
            'periodo' => [
                'required' => 'Il periodo è obbligatorio',
                'date' => 'Le date devono essere valide',
                'after' => 'La data di fine deve essere successiva all\'inizio',
            ],
        ],
        'errors' => [
            'calculation_failed' => 'Calcolo delle performance fallito',
            'missing_data' => 'Dati insufficienti per il calcolo',
            'invalid_period' => 'Periodo non valido',
            'no_stabilimenti' => 'Nessuno stabilimento trovato nella regione',
        ],
        'warnings' => [
            'incomplete_data' => 'Dati incompleti per alcuni stabilimenti',
            'performance_gap' => 'Rilevato gap significativo tra stabilimenti',
            'trend_negative' => 'Trend negativo rilevato',
        ],
        'info' => [
            'calculation_started' => 'Calcolo performance avviato',
            'export_ready' => 'Report pronto per il download',
            'comparison_available' => 'Confronto con altre regioni disponibile',
        ],
    ],
    'model' => [
        'label' => 'individuale regionale.model',
    ],
    'label' => 'individuale regionale',
];
