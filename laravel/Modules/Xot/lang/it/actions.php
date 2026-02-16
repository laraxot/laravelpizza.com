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
        ],
        'created_at' => [
            'label' => 'Data Creazione',
        ],
        'updated_at' => [
            'label' => 'Ultima Modifica',
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
