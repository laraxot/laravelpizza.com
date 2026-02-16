<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => '',
        'plural_label' => '',
    ],
    'label' => '',
    'plural_label' => '',
    'fields' => [
        'startDate' => [
            'label' => 'Data Inizio',
            'description' => 'Data di inizio',
            'helper_text' => 'Data di inizio',
            'placeholder' => 'Seleziona data inizio',
        ],
        'endDate' => [
            'label' => 'Data Fine',
            'description' => 'Data di fine',
            'helper_text' => 'Data di fine',
            'placeholder' => 'Seleziona data fine',
        ],
    ],
    'sections' => [
        'empty' => [
            'heading' => 'Nessun Dato',
            'label' => 'Vuoto',
        ],
    ],
    'actions' => [
        'logout' => [
            'icon' => 'logout',
            'label' => 'logout',
            'tooltip' => 'logout',
        ],
        'profile' => [
            'icon' => 'profile',
            'label' => 'profile',
            'tooltip' => 'profile',
        ],
    ],
];
