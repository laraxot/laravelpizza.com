<?php

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
            'label' => 'toggleColumns',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'edit' => [
            'label' => 'edit',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'content' => [
            'description' => 'content',
            'helper_text' => 'content',
            'placeholder' => 'content',
            'label' => '',
            'tooltip' => '',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
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
            'label' => 'openFilters',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'key' => [
            'label' => 'key',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
            'placeholder' => 'Inserisci chiave traduzione',
            'help' => 'Chiave identificativa della traduzione',
        ],
        'delete' => [
            'label' => 'delete',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'create',
            'tooltip' => 'Crea nuovo file di traduzione',
            'success' => 'File di traduzione creato con successo',
        ],
        'lang' => [
            'label' => 'lang',
            'tooltip' => 'Seleziona lingua',
        ],
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
];
