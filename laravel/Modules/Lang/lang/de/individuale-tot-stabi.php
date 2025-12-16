<?php

declare(strict_types=1);

return [
    'fields' => [
        'stabilimento' => [
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
        ],
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
        'created_at' => [
            'label' => 'Data Creazione',
            'help' => 'Data di creazione del record',
        ],
        'updated_at' => [
            'label' => 'Ultimo Aggiornamento',
            'help' => 'Data dell\'ultima modifica',
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
];
