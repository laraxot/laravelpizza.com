<?php

declare(strict_types=1);

return [
    'actions' => [
        'toggle' => [
            'label' => 'Tabelindeling wisselen',
        ],
    ],
    'table_layout' => [
        'actions' => [
            'toggle' => [
                'label' => 'Indeling wisselen',
                'tooltip' => 'Wisselen tussen lijst- en rasterweergave',
                'helper_text' => 'Wijzig het weergavetype',
            ],
        ],
    ],
    'fields' => [
        'layout' => [
            'label' => 'Indeling',
            'placeholder' => 'Selecteer indelingstype',
            'tooltip' => 'Kies tussen lijst- en rasterweergave',
            'help' => 'Kies het meest geschikte indelingstype om de gegevens weer te geven',
        ],
    ],
];
