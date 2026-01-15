<?php

declare(strict_types=1);

return [
    'actions' => [
        'toggle' => [
            'label' => 'Cambia Layout Tabella',
        ],
    ],
    'table_layout' => [
        'actions' => [
            'toggle' => [
                'label' => 'Cambia Layout',
                'tooltip' => 'Passa da vista a elenco a vista a griglia',
                'helper_text' => 'Cambia il tipo di visualizzazione',
            ],
        ],
    ],
    'fields' => [
        'layout' => [
            'label' => 'Layout',
            'placeholder' => 'Seleziona tipo di layout',
            'tooltip' => 'Scegli tra vista a elenco e vista a griglia',
            'help' => 'Scegli il tipo di layout più adatto per visualizzare i dati',
        ],
    ],
];
