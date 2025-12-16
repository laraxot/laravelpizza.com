<?php

declare(strict_types=1);

return [
    'actions' => [
        'create' => [
            'label' => 'Crea Opzione',
            'tooltip' => 'Crea una nuova opzione campo',
            'success' => 'Opzione creata con successo',
        ],
    ],
    'fields' => [
        'edit' => [
            'label' => 'Modifica',
            'tooltip' => 'Modifica opzione',
        ],
        'openFilters' => [
            'label' => 'Apri Filtri',
            'tooltip' => 'Apri il pannello dei filtri',
        ],
        'applyFilters' => [
            'label' => 'Applica Filtri',
            'tooltip' => 'Applica i filtri selezionati',
        ],
        'resetFilters' => [
            'label' => 'Reset Filtri',
            'tooltip' => 'Ripristina i filtri predefiniti',
        ],
        'toggleColumns' => [
            'label' => 'Mostra/Nascondi Colonne',
            'tooltip' => 'Mostra o nascondi colonne della tabella',
        ],
        'reorderRecords' => [
            'label' => 'Riordina Record',
            'tooltip' => 'Riordina i record della tabella',
        ],
        'type' => [
            'label' => 'Tipo',
            'placeholder' => 'Seleziona tipo opzione',
            'helper_text' => 'Tipo di opzione del campo',
        ],
        'key' => [
            'label' => 'Chiave',
            'placeholder' => 'Inserisci chiave opzione',
            'helper_text' => 'Chiave identificativa dell\'opzione',
        ],
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci nome opzione',
            'helper_text' => 'Nome dell\'opzione del campo',
        ],
    ],
    'navigation' => [
        'label' => 'Opzioni Campi',
        'sort' => 78,
        'icon' => 'heroicon-o-cog-6-tooth',
        'group' => 'UI',
    ],
    'model' => [
        'label' => 'Modello Opzione Campo',
        'placeholder' => 'Seleziona modello',
        'helper_text' => 'Modello per la gestione delle opzioni campo',
    ],
];
