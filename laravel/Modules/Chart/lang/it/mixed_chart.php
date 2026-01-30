<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Grafici Misti',
        'group' => 'Analisi',
        'icon' => 'heroicon-o-chart-bar',
        'sort' => 77,
    ],
    'fields' => [
        'chart_type' => [
            'label' => 'Tipo Grafico',
            'placeholder' => 'Seleziona tipo grafico',
            'helper_text' => 'Tipo di grafico da visualizzare',
        ],
        'data_source' => [
            'label' => 'Fonte Dati',
            'placeholder' => 'Seleziona fonte dati',
            'helper_text' => 'Fonte dei dati per il grafico',
        ],
        'display_options' => [
            'label' => 'Opzioni Visualizzazione',
            'placeholder' => 'Configura opzioni',
            'helper_text' => 'Opzioni per la visualizzazione del grafico',
        ],
    ],
];
