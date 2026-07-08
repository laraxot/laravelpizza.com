<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Consultazione anagrafica',
        'label' => 'Consultazione anagrafica',
        'group' => 'PDND',
        'icon' => 'heroicon-o-magnifying-glass-circle',
        'sort' => 54,
    ],
    'actions' => [
        'pdndFormActions' => [
            'label' => 'Ricerca',
        ],
    ],
    'fields' => [
        'codiceFiscale' => [
            'description' => 'codiceFiscale',
            'helper_text' => 'codiceFiscale',
        ],
    ],
];
