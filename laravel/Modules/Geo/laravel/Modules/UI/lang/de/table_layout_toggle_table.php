<?php

declare(strict_types=1);

return [
    'actions' => [
        'toggle' => [
            'label' => 'Tabellenlayout umschalten',
        ],
    ],
    'table_layout' => [
        'actions' => [
            'toggle' => [
                'label' => 'Layout wechseln',
                'tooltip' => 'Zwischen Listen- und Rasteransicht wechseln',
                'helper_text' => 'Anzeigetyp ändern',
            ],
        ],
    ],
    'fields' => [
        'layout' => [
            'label' => 'Layout',
            'placeholder' => 'Layout-Typ auswählen',
            'tooltip' => 'Zwischen Listen- und Rasteransicht wählen',
            'help' => 'Wählen Sie den am besten geeigneten Layout-Typ zur Anzeige der Daten',
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
