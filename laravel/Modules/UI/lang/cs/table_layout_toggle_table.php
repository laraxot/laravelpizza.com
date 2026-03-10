<?php

declare(strict_types=1);

return [
    'actions' => [
        'toggle' => [
            'label' => 'Přepnout rozložení tabulky',
        ],
    ],
    'table_layout' => [
        'actions' => [
            'toggle' => [
                'label' => 'Přepnout rozložení',
                'tooltip' => 'Přepnout mezi zobrazením seznamu a mřížky',
                'helper_text' => 'Změnit typ zobrazení',
            ],
        ],
    ],
    'fields' => [
        'layout' => [
            'label' => 'Rozložení',
            'placeholder' => 'Vyberte typ rozložení',
            'tooltip' => 'Zvolte mezi zobrazením seznamu a mřížky',
            'help' => 'Vyberte vhodný typ rozložení pro zobrazení dat',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'navigation' => [
        'label' => 'Missing Navigation Label',
        'plural_label' => 'Missing Navigation Plural Label',
        'group' => 'Missing Group',
        'icon' => 'heroicon-o-puzzle-piece',
        'sort' => 100,
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
];
