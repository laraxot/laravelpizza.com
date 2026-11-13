<?php

declare(strict_types=1);

return [
    'actions' => [
        'create' => [
            'label' => 'Crea',
            'tooltip' => 'Crea nuovo file di traduzione',
            'success' => 'File di traduzione creato con successo',
            'icon' => 'create',
        ],
        'lang' => [
            'label' => 'Lingua',
            'tooltip' => 'Seleziona lingua',
            'icon' => 'lang',
        ],
        'logout' => [
            'tooltip' => '',
            'icon' => 'logout',
            'label' => 'Esci',
        ],
        'applyFilters' => [
            'label' => 'Applica filtri',
            'icon' => 'applyFilters',
            'tooltip' => '',
        ],
        'openFilters' => [
            'label' => 'Filtri',
            'icon' => 'openFilters',
            'tooltip' => '',
        ],
        'resetFilters' => [
            'label' => 'Azzera filtri',
            'icon' => 'resetFilters',
            'tooltip' => '',
        ],
        'applyTableColumnManager' => [
            'label' => 'Applica colonne',
            'icon' => 'applyTableColumnManager',
            'tooltip' => '',
        ],
        'openColumnManager' => [
            'label' => 'Scegli colonne',
            'icon' => 'openColumnManager',
            'tooltip' => '',
        ],
        'resetColumnManager' => [
            'label' => 'Ripristina colonne',
            'icon' => 'resetColumnManager',
            'tooltip' => '',
        ],
        'reorderRecords' => [
            'label' => 'Riordina',
            'icon' => 'reorderRecords',
            'tooltip' => '',
        ],
        'removeAllFilters' => [
            'label' => 'Rimuovi tutti i filtri',
            'icon' => 'removeAllFilters',
            'tooltip' => '',
        ],
        'profile' => [
            'tooltip' => '',
            'icon' => 'profile',
            'label' => 'Profile',
        ],
        'cancel' => [
            'tooltip' => '',
            'icon' => 'cancel',
        ],
        'save' => [
            'icon' => 'save',
        ],
    ],
    'fields' => [
        'edit' => [
            'label' => 'Modifica',
            'tooltip' => 'Modifica file di traduzione',
            'helper_text' => '',
            'description' => '',
        ],
        'toggleColumns' => [
            'label' => 'Mostra/Nascondi Colonne',
            'tooltip' => 'Mostra o nascondi colonne della tabella',
            'helper_text' => '',
            'description' => '',
        ],
        'reorderRecords' => [
            'label' => 'Riordina Record',
            'tooltip' => 'Riordina i record nella tabella',
            'helper_text' => '',
            'description' => '',
        ],
        'resetFilters' => [
            'label' => 'Reset Filtri',
            'tooltip' => 'Ripristina i filtri ai valori predefiniti',
            'helper_text' => '',
            'description' => '',
        ],
        'content' => [
            'description' => 'Contenuto del file di traduzione',
            'helper_text' => '',
            'placeholder' => 'Inserisci contenuto traduzione',
            'label' => 'Contenuto',
            'tooltip' => '',
        ],
        'applyFilters' => [
            'label' => 'Applica Filtri',
            'tooltip' => 'Applica i filtri selezionati',
            'helper_text' => '',
            'description' => '',
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
            'label' => 'Istantanee',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'openFilters' => [
            'label' => 'Apri Filtri',
            'tooltip' => 'Apri il pannello dei filtri',
            'helper_text' => '',
            'description' => '',
        ],
        'key' => [
            'label' => 'Chiave',
            'placeholder' => 'Inserisci chiave traduzione',
            'help' => 'Chiave identificativa della traduzione',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'delete' => [
            'label' => 'Elimina',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'navigation' => [
        'label' => 'File Traduzione',
        'group' => 'Lang',
        'icon' => 'heroicon-o-language',
        'sort' => '73',
    ],
    'model' => [
        'label' => 'File Traduzione',
        'placeholder' => 'Seleziona file traduzione',
        'helper_text' => 'File di traduzione per la gestione delle lingue',
    ],
    'label' => 'Translation File',
    'plural_label' => 'Translation File (Plurale)',
];
