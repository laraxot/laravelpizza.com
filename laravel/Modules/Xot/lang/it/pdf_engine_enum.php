<?php

declare(strict_types=1);

return [
    'values' => [
        'spipu' => [
            'label' => 'Spipu',
            'icon' => 'heroicon-o-table-cells',
            'color' => 'info',
            'description' => 'Motore PDF basato su TCPDF/mPDF per report tabellari',
        ],
        'spatie' => [
            'label' => 'Spatie',
            'icon' => 'heroicon-o-document-text',
            'color' => 'primary',
            'description' => 'Motore PDF basato su DomPDF per documenti HTML/CSS',
        ],
    ],
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
        'label' => 'Motore PDF',
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
        'spipu' => ['label' => 'spipu', 'placeholder' => 'spipu', 'helper_text' => 'spipu', 'description' => 'spipu'],
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
    'test' => 'pdf engine enum',
];
