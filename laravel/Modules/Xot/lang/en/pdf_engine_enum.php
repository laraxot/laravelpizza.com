<?php

declare(strict_types=1);

return [
    'values' => [
        'spipu' => [
            'label' => 'Spipu',
            'icon' => 'heroicon-o-table-cells',
            'color' => 'info',
            'description' => 'PDF engine based on TCPDF/mPDF for tabular reports',
        ],
        'spatie' => [
            'label' => 'Spatie',
            'icon' => 'heroicon-o-document-text',
            'color' => 'primary',
            'description' => 'PDF engine based on DomPDF for HTML/CSS documents',
        ],
    ],
    'label' => 'PDF Engine',
    'options' => [
        'spipu' => 'Spipu',
        'spatie' => 'Spatie',
    ],
    'navigation' => [
        'label' => 'PDF Engine',
        'plural_label' => 'Missing Navigation Plural Label',
        'group' => 'Missing Group',
        'icon' => 'heroicon-o-puzzle-piece',
        'sort' => 100,
    ],
    'plural_label' => 'Missing Plural label',
    'fields' => [
    ],
    'actions' => [
    ],
];
