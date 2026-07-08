<?php

declare(strict_types=1);

return [
    'export_xls' => 'Esporta Dati',
    'label' => 'Actions',
    'plural_label' => 'Actions (Plurale)',
    'navigation' => [
        'name' => 'Actions',
        'plural' => 'Actions',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Actions',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
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
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Actions',
        ],
        'edit' => [
            'label' => 'Modifica Actions',
        ],
        'delete' => [
            'label' => 'Elimina Actions',
        ],
    ],
];
