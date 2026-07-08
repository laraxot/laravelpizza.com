<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'PDND',
        'plural' => 'PDND',
        'label' => 'PDND',
        'group' => 'Servizi Esterni',
        'icon' => 'heroicon-o-globe-alt',
        'sort' => 50,
    ],
    'actions' => [
        'pdndFormActions' => [
            'label' => 'Ricerca',
        ],
    ],
    'fields' => [
        'codice_fiscale' => [
            'description' => 'codice_fiscale',
            'helper_text' => 'codice_fiscale',
            'placeholder' => 'codice_fiscale',
            'label' => 'Codice Fiscale',
        ],
        'codiceFiscale' => [
            'description' => 'codiceFiscale',
            'helper_text' => 'codiceFiscale',
            'placeholder' => 'codiceFiscale',
            'label' => 'Codice Fiscale',
        ],
    ],
];
