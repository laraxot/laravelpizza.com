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
            'tooltip' => '',
            'description' => '',
        ],
        'itemKey' => [
            'label' => 'Chiave Elemento',
            'placeholder' => 'Inserisci chiave elemento',
            'helper_text' => 'Chiave identificativa dell\'elemento',
            'tooltip' => '',
            'description' => '',
        ],
        'itemValue' => [
            'label' => 'Valore Elemento',
            'placeholder' => 'Inserisci valore elemento',
            'helper_text' => 'Valore dell\'elemento della collezione',
            'tooltip' => '',
            'description' => '',
        ],
        'values' => [
            'label' => 'Valori',
            'placeholder' => 'Inserisci valori',
            'helper_text' => 'Valori della collezione',
            'tooltip' => '',
            'description' => '',
        ],
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci nome collezione',
            'helper_text' => 'Nome identificativo della collezione',
            'tooltip' => '',
            'description' => '',
        ],
    ],
    'label' => 'Collection Lang',
    'plural_label' => 'Collection Lang (Plurale)',
    'actions' => [
        'create' => [
            'label' => 'Crea Collection Lang',
        ],
        'edit' => [
            'label' => 'Modifica Collection Lang',
        ],
        'delete' => [
            'label' => 'Elimina Collection Lang',
        ],
    ],
];
