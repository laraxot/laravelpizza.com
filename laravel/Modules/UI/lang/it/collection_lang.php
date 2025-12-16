<?php

declare(strict_types=1);

return [
    'model' => [
        'label' => 'Modello Collezione',
        'placeholder' => 'Seleziona modello',
        'helper_text' => 'Modello per la gestione delle collezioni',
    ],
    'navigation' => [
        'label' => 'Collezioni',
        'group' => 'UI',
        'icon' => 'heroicon-o-collection',
        'sort' => 68,
    ],
    'fields' => [
        'itemIsDefault' => [
            'label' => 'Elemento Predefinito',
            'placeholder' => 'Seleziona elemento predefinito',
            'helper_text' => 'Elemento predefinito della collezione',
        ],
        'itemKey' => [
            'label' => 'Chiave Elemento',
            'placeholder' => 'Inserisci chiave elemento',
            'helper_text' => 'Chiave identificativa dell\'elemento',
        ],
        'itemValue' => [
            'label' => 'Valore Elemento',
            'placeholder' => 'Inserisci valore elemento',
            'helper_text' => 'Valore dell\'elemento della collezione',
        ],
        'values' => [
            'label' => 'Valori',
            'placeholder' => 'Inserisci valori',
            'helper_text' => 'Valori della collezione',
        ],
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci nome collezione',
            'helper_text' => 'Nome identificativo della collezione',
        ],
    ],
];
