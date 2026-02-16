<?php

declare(strict_types=1);

return [
    'label' => 'Motore PDF',
    'options' => [
        'spipu' => 'Spipu',
        'spatie' => 'Spatie',
    ],
    'plural_label' => 'Pdf Engine Enum (Plurale)',
    'navigation' => [
        'name' => 'Pdf Engine Enum',
        'plural' => 'Pdf Engine Enum',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Pdf Engine Enum',
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
            'label' => 'Crea Pdf Engine Enum',
        ],
        'edit' => [
            'label' => 'Modifica Pdf Engine Enum',
        ],
        'delete' => [
            'label' => 'Elimina Pdf Engine Enum',
        ],
    ],
];
