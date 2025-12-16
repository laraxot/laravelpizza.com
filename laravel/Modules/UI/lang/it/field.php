<?php

declare(strict_types=1);

return [
    'actions' => [
        'create' => [
            'label' => 'Crea Campo',
            'tooltip' => 'Crea un nuovo campo',
            'success' => 'Campo creato con successo',
        ],
    ],
    'fields' => [
        'edit' => [
            'label' => 'Modifica',
            'tooltip' => 'Modifica campo',
        ],
        'toggleColumns' => [
            'label' => 'Mostra/Nascondi Colonne',
            'tooltip' => 'Mostra o nascondi colonne della tabella',
        ],
        'reorderRecords' => [
            'label' => 'Riordina Record',
            'tooltip' => 'Riordina i record della tabella',
        ],
        'resetFilters' => [
            'label' => 'Reset Filtri',
            'tooltip' => 'Ripristina i filtri predefiniti',
        ],
        'applyFilters' => [
            'label' => 'Applica Filtri',
            'tooltip' => 'Applica i filtri selezionati',
        ],
        'openFilters' => [
            'label' => 'Apri Filtri',
            'tooltip' => 'Apri il pannello dei filtri',
        ],
    ],
    'navigation' => [
        'label' => 'Campi',
        'sort' => 46,
        'icon' => 'heroicon-o-rectangle-stack',
        'group' => 'UI',
    ],
    'model' => [
        'label' => 'Modello Campo',
        'placeholder' => 'Seleziona modello',
        'helper_text' => 'Modello per la gestione dei campi',
    ],
];
