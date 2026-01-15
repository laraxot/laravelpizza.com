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
        ],
    ],
];
