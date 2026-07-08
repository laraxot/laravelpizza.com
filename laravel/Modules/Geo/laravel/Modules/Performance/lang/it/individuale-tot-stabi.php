<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Totale Stabilimento',
        'plural' => 'Totali Stabilimenti',
        'group' => [
            'name' => 'Valutazione',
            'description' => 'Gestione delle performance individuali',
        ],
        'label' => 'Totali Stabilimento',
        'sort' => 52,
        'icon' => 'heroicon-o-building-office',
    ],
    'fields' => [
        'stabilimento' => [
            'name' => [
                'label' => 'Nome Stabilimento',
                'placeholder' => 'Inserisci il nome dello stabilimento',
                'help' => 'Nome identificativo dello stabilimento',
            ],
            'codice' => [
                'label' => 'Codice',
                'placeholder' => 'Inserisci il codice stabilimento',
                'help' => 'Codice univoco dello stabilimento',
            ],
            'tipo' => [
                'label' => 'Tipologia',
                'placeholder' => 'Seleziona la tipologia',
                'help' => 'Tipo di stabilimento',
                'options' => [
                    'produzione' => 'Produzione',
                    'servizi' => 'Servizi',
                    'amministrativo' => 'Amministrativo',
                ],
            ],
        ],
        'performance' => [
            'totale' => [
                'label' => 'Totale Performance',
                'placeholder' => 'Inserisci il totale',
                'help' => 'Punteggio totale delle performance',
            ],
            'media' => [
                'label' => 'Media Performance',
                'help' => 'Media delle performance individuali',
            ],
            'periodo' => [
                'label' => 'Periodo',
                'placeholder' => 'Seleziona il periodo',
                'help' => 'Periodo di riferimento',
            ],
        ],
        'dipendenti' => [
            'numero' => [
                'label' => 'Numero Dipendenti',
                'help' => 'Totale dipendenti dello stabilimento',
            ],
            'valutati' => [
                'label' => 'Dipendenti Valutati',
                'help' => 'Numero di dipendenti con valutazione',
            ],
            'da_valutare' => [
                'label' => 'Da Valutare',
                'help' => 'Dipendenti in attesa di valutazione',
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
        'toggleColumns' => [
            'label' => 'toggleColumns',
        ],
    ],
    'actions' => [
        'calculate' => [
            'label' => 'Calcola Totali',
            'success' => 'Totali calcolati con successo',
            'error' => 'Errore durante il calcolo dei totali',
        ],
        'export' => [
            'label' => 'Esporta Report',
            'success' => 'Report esportato con successo',
            'error' => 'Errore durante l\'esportazione',
        ],
        'refresh' => [
            'label' => 'Aggiorna',
            'success' => 'Dati aggiornati con successo',
            'error' => 'Errore durante l\'aggiornamento',
        ],
    ],
    'messages' => [
        'validation' => [
            'totale' => [
                'required' => 'Il totale è obbligatorio',
                'numeric' => 'Il totale deve essere numerico',
                'min' => 'Il totale deve essere maggiore di zero',
            ],
            'periodo' => [
                'required' => 'Il periodo è obbligatorio',
                'date' => 'Il periodo deve essere una data valida',
            ],
        ],
        'errors' => [
            'calculation_failed' => 'Calcolo dei totali fallito',
            'missing_data' => 'Dati insufficienti per il calcolo',
            'invalid_period' => 'Periodo non valido',
        ],
        'warnings' => [
            'incomplete_evaluations' => 'Valutazioni incomplete',
            'missing_employees' => 'Dipendenti mancanti',
            'outdated_data' => 'Dati non aggiornati',
        ],
        'info' => [
            'calculation_started' => 'Calcolo totali avviato',
            'export_ready' => 'Report pronto per il download',
            'data_updated' => 'Dati aggiornati all\'ultima versione',
        ],
        'success' => [
            'created' => 'Record creato con successo',
            'updated' => 'Record aggiornato con successo',
            'deleted' => 'Record eliminato con successo',
        ],
        'error' => [
            'created' => 'Errore durante la creazione del record',
            'updated' => 'Errore durante l\'aggiornamento del record',
            'deleted' => 'Errore durante l\'eliminazione del record',
        ],
    ],
];
