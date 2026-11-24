<?php

declare(strict_types=1);

return [
    'model' => [
        'label' => 'translation file.model',
        'placeholder' => 'Seleziona file traduzione',
        'helper_text' => 'File di traduzione per la gestione delle lingue',
    ],
    'navigation' => [
        'label' => 'Navigation Label',
        'group' => 'Lang',
        'icon' => 'heroicon-o-cog',
        'sort' => '23',
    ],
    'fields' => [
        'toggleColumns' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
            'label' => 'Mostra/Nascondi Colonne',
        ],
        'reorderRecords' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
            'label' => 'Riordina Record',
        ],
        'edit' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
            'label' => 'Modifica',
        ],
        'resetFilters' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
            'label' => 'Reset Filtri',
        ],
        'content' => [
            'label' => '',
            'tooltip' => '',
            'description' => 'Contenuto del file di traduzione',
            'helper_text' => '',
            'placeholder' => 'Inserisci contenuto traduzione',
        ],
        'applyFilters' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
            'label' => 'Applica Filtri',
        ],
        'snapshots' => [
            'fields' => [
                'updated_at' => [
                    'help' => [
                        'description' => 'snapshots.fields.updated_at.help',
                        'helper_text' => 'snapshots.fields.updated_at.help',
                        'placeholder' => 'snapshots.fields.updated_at.help',
                        'label' => 'snapshots.fields.updated_at.help',
                    ],
                    'label' => [
                        'description' => 'snapshots.fields.updated_at.label',
                        'helper_text' => 'snapshots.fields.updated_at.label',
                        'placeholder' => 'snapshots.fields.updated_at.label',
                        'label' => 'Etichetta Data',
                    ],
                ],
            ],
            'label' => '',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'openFilters' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
            'label' => 'Apri Filtri',
        ],
        'key' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
            'placeholder' => 'Inserisci chiave traduzione',
            'help' => 'Chiave identificativa della traduzione',
            'label' => 'Chiave',
        ],
        'delete' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
            'label' => 'Elimina',
        ],
    ],
    'actions' => [
        'create' => [
            'tooltip' => 'Crea nuovo file di traduzione',
            'success' => 'File di traduzione creato con successo',
            'label' => 'Crea',
            'icon' => 'create',
        ],
        'lang' => [
            'tooltip' => 'Seleziona lingua',
            'label' => 'Lingua',
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
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
];
