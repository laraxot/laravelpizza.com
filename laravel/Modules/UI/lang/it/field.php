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
            'helper_text' => '',
            'description' => '',
        ],
        'toggleColumns' => [
            'label' => 'Mostra/Nascondi Colonne',
            'tooltip' => 'Mostra o nascondi colonne della tabella',
            'helper_text' => '',
            'description' => '',
        ],
        'reorderRecords' => [
            'label' => 'Riordina Record',
            'tooltip' => 'Riordina i record della tabella',
            'helper_text' => '',
            'description' => '',
        ],
        'resetFilters' => [
            'label' => 'Reset Filtri',
            'tooltip' => 'Ripristina i filtri predefiniti',
            'helper_text' => '',
            'description' => '',
        ],
        'applyFilters' => [
            'label' => 'Applica Filtri',
            'tooltip' => 'Applica i filtri selezionati',
            'helper_text' => '',
            'description' => '',
        ],
        'openFilters' => [
            'label' => 'Apri Filtri',
            'tooltip' => 'Apri il pannello dei filtri',
            'helper_text' => '',
            'description' => '',
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
    'label' => 'Field',
    'plural_label' => 'Field (Plurale)',
];
