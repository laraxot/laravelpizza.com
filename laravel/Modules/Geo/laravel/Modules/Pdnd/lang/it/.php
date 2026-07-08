<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'PDND',
        'plural' => 'PDND',
        'label' => 'PDND',
        'group' => [
            'name' => 'Servizi Esterni',
            'description' => 'Integrazione con servizi PDND e anagrafe nazionale',
        ],
        'sort' => 50,
        'icon' => 'heroicon-o-globe-alt',
    ],
    'sections' => [
        'empty' => [
            'heading' => 'empty',
            'label' => 'empty',
        ],
    ],
    'actions' => [
        'logout' => [
            'icon' => 'logout',
            'tooltip' => 'logout',
            'label' => 'logout',
        ],
        'profile' => [
            'tooltip' => 'profile',
            'icon' => 'profile',
            'label' => 'profile',
        ],
    ],
];
