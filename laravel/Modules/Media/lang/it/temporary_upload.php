<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Caricamento temporaneo',
        'group' => 'Caricamento temporaneo',
        'icon' => 'media-temp-upload-animated',
        'sort' => 96,
    ],
    'label' => 'Caricamento temporaneo',
    'plural_label' => 'Caricamenti temporanei',
    'fields' => [
        'id' => [
            'label' => 'Identificativo',
            'tooltip' => 'Identificativo univoco del record',
            'helper_text' => '',
            'description' => '',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'updated_at' => [
            'label' => 'Ultima Modifica',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'value' => [
            'label' => 'value',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea caricamento temporaneo',
        ],
        'edit' => [
            'label' => 'Modifica caricamento temporaneo',
        ],
        'delete' => [
            'label' => 'Elimina caricamento temporaneo',
        ],
        'logout' => [
            'label' => 'logout',
        ],
        'createAnother' => [
            'label' => 'createAnother',
        ],
        'cancel' => [
            'label' => 'cancel',
        ],
        'profile' => [
            'label' => 'profile',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
        ],
        'applyTableColumnManager' => [
            'label' => 'applyTableColumnManager',
        ],
        'openColumnManager' => [
            'label' => 'openColumnManager',
        ],
        'resetColumnManager' => [
            'label' => 'resetColumnManager',
        ],
    ],
];
