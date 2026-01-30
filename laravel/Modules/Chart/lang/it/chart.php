<?php

declare(strict_types=1);

return [
    'fields' => [
        'id' => [
            'label' => 'ID',
            'placeholder' => 'Inserisci ID',
            'helper_text' => 'Identificativo univoco del grafico',
        ],
        'type' => [
            'label' => 'Tipo',
            'placeholder' => 'Seleziona tipo',
            'helper_text' => 'Tipo di grafico da visualizzare',
        ],
        'group_by' => [
            'label' => 'Raggruppa per',
            'placeholder' => 'Seleziona campo',
            'helper_text' => 'Campo per il raggruppamento dei dati',
        ],
        'sort_by' => [
            'label' => 'Ordina per',
            'placeholder' => 'Seleziona campo',
            'helper_text' => 'Campo per l\'ordinamento dei dati',
        ],
        'width' => [
            'label' => 'Larghezza',
            'placeholder' => 'Inserisci larghezza',
            'helper_text' => 'Larghezza del grafico in pixel',
        ],
        'height' => [
            'label' => 'Altezza',
            'placeholder' => 'Inserisci altezza',
            'helper_text' => 'Altezza del grafico in pixel',
        ],
        'font_family' => [
            'label' => 'Famiglia font',
            'placeholder' => 'Seleziona famiglia font',
            'helper_text' => 'Famiglia di font per il testo',
        ],
        'font_style' => [
            'label' => 'Stile font',
            'placeholder' => 'Seleziona stile font',
            'helper_text' => 'Stile del font (normale, grassetto, corsivo)',
        ],
        'font_size' => [
            'label' => 'Dimensione font',
            'placeholder' => 'Inserisci dimensione font',
            'helper_text' => 'Dimensione del font in pixel',
        ],
        'show_box' => [
            'label' => 'Mostra box',
            'placeholder' => '',
            'helper_text' => 'Mostra il box di controllo del grafico',
        ],
        'list_color' => [
            'label' => 'Colore lista',
            'placeholder' => 'Seleziona colore',
            'helper_text' => 'Colore per gli elementi della lista',
        ],
        'transparency' => [
            'label' => 'Trasparenza',
            'placeholder' => 'Inserisci valore trasparenza',
            'helper_text' => 'Livello di trasparenza (0-100)',
        ],
    ],
    'navigation' => [
        'label' => 'Grafici',
        'group' => 'Analisi',
        'icon' => 'heroicon-o-chart-bar',
        'sort' => 20,
    ],
];
