<?php

declare(strict_types=1);

return [
    'navigation' => [
        'group' => 'AMBIENTE TEST',
    ],
    'actions' => [
        'pdndFormActions' => [
            'label' => 'Ricerca',
        ],
        'logout' => [
            'icon' => 'logout',
            'label' => 'logout',
            'tooltip' => 'logout',
        ],
        'profile' => [
            'icon' => 'profile',
            'tooltip' => 'profile',
            'label' => 'profile',
        ],
    ],
    'fields' => [
        'codiceFiscale' => [
            'description' => 'codiceFiscale',
            'helper_text' => 'codiceFiscale',
            'placeholder' => 'codiceFiscale',
            'label' => 'Codice Fiscale',
        ],
    ],
    'sections' => [
        'empty' => [
            'heading' => 'empty',
            'label' => 'empty',
        ],
    ],
];
