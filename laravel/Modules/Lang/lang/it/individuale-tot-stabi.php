<?php

declare(strict_types=1);

return [
    'fields' => [
        'stabilimento' => [
            'label' => 'Nome Stabilimento',
            'placeholder' => 'Inserisci il nome dello stabilimento',
            'help' => 'Nome identificativo dello stabilimento',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'codice' => [
            'label' => 'Codice',
            'placeholder' => 'Inserisci il codice stabilimento',
            'help' => 'Codice univoco dello stabilimento',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'tipo' => [
            'label' => 'Tipologia',
            'placeholder' => 'Seleziona la tipologia',
            'help' => 'Tipo di stabilimento',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'totale' => [
            'label' => 'Totale Performance',
            'placeholder' => 'Inserisci il totale',
            'help' => 'Punteggio totale delle performance',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'media' => [
            'label' => 'Media Performance',
            'help' => 'Media delle performance individuali',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'periodo' => [
            'label' => 'Periodo',
            'placeholder' => 'Seleziona il periodo',
            'help' => 'Periodo di riferimento',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'numero' => [
            'label' => 'Numero Dipendenti',
            'help' => 'Totale dipendenti dello stabilimento',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'valutati' => [
            'label' => 'Dipendenti Valutati',
            'help' => 'Numero di dipendenti con valutazione',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'da_valutare' => [
            'label' => 'Da Valutare',
            'help' => 'Dipendenti in attesa di valutazione',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
            'help' => 'Data di creazione del record',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'updated_at' => [
            'label' => 'Ultimo Aggiornamento',
            'help' => 'Data dell\'ultima modifica',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
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
    'label' => 'Individuale Tot Stabi',
    'plural_label' => 'Individuale Tot Stabi (Plurale)',
    'navigation' => [
        'name' => 'Individuale Tot Stabi',
        'plural' => 'Individuale Tot Stabi',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Individuale Tot Stabi',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
];
