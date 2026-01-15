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
        ],
    ],
];
