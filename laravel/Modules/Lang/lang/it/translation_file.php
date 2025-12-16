<?php

declare(strict_types=1);

return [
    'actions' => [
        'create' => [
            'label' => 'Crea',
            'tooltip' => 'Crea nuovo file di traduzione',
            'success' => 'File di traduzione creato con successo',
        ],
        'lang' => [
            'label' => 'Lingua',
            'tooltip' => 'Seleziona lingua',
        ],
    ],
    'fields' => [
        'edit' => [
            'label' => 'Modifica',
            'tooltip' => 'Modifica file di traduzione',
        ],
        'toggleColumns' => [
            'label' => 'Mostra/Nascondi Colonne',
            'tooltip' => 'Mostra o nascondi colonne della tabella',
        ],
        'reorderRecords' => [
            'label' => 'Riordina Record',
            'tooltip' => 'Riordina i record nella tabella',
        ],
        'resetFilters' => [
            'label' => 'Reset Filtri',
            'tooltip' => 'Ripristina i filtri ai valori predefiniti',
        ],
        'content' => [
            'description' => 'Contenuto del file di traduzione',
            'helper_text' => '',
            'placeholder' => 'Inserisci contenuto traduzione',
            'label' => 'Contenuto',
        ],
        'applyFilters' => [
            'label' => 'Applica Filtri',
            'tooltip' => 'Applica i filtri selezionati',
        ],
        'snapshots' => [
            'fields' => [
                'updated_at' => [
                    'help' => [
                        'description' => 'Data e ora dell\'ultimo aggiornamento',
                        'helper_text' => '',
                        'placeholder' => 'Data aggiornamento',
                        'label' => 'Data Aggiornamento',
                    ],
                    'label' => [
                        'description' => 'Etichetta per la data di aggiornamento',
                        'helper_text' => '',
                        'placeholder' => 'Etichetta data',
                        'label' => 'Etichetta Data',
                    ],
                ],
            ],
        ],
        'openFilters' => [
            'label' => 'Apri Filtri',
            'tooltip' => 'Apri il pannello dei filtri',
        ],
        'key' => [
            'label' => 'Chiave',
            'placeholder' => 'Inserisci chiave traduzione',
            'help' => 'Chiave identificativa della traduzione',
        ],
        'delete' => [
            'label' => 'delete',
        ],
    ],
    'navigation' => [
        'label' => 'File Traduzione',
        'group' => 'Lang',
        'icon' => 'heroicon-o-language',
        'sort' => 73,
    ],
    'model' => [
        'label' => 'File Traduzione',
        'placeholder' => 'Seleziona file traduzione',
        'helper_text' => 'File di traduzione per la gestione delle lingue',
    ],
];
