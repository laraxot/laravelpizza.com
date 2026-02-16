<?php

declare(strict_types=1);

return [
    'list' => [
        'label' => 'Lista',
        'description' => 'Visualizzazione a lista tradizionale',
        'tooltip' => 'Mostra elementi in formato lista',
        'helper_text' => 'Layout tradizionale con righe e colonne',
        'color' => 'primary',
        'icon' => 'heroicon-o-list-bullet',
    ],
    'grid' => [
        'label' => 'Griglia',
        'description' => 'Visualizzazione a griglia con card',
        'tooltip' => 'Mostra elementi in formato griglia',
        'helper_text' => 'Layout a griglia con card responsive',
        'color' => 'secondary',
        'icon' => 'heroicon-o-squares-2x2',
    ],
    'toggle' => [
        'label' => 'Cambia Layout',
        'tooltip' => 'Alterna tra visualizzazione lista e griglia',
        'helper_text' => 'Cambia il tipo di visualizzazione',
    ],
    'label' => 'Table Layout',
    'plural_label' => 'Table Layout (Plurale)',
    'navigation' => [
        'name' => 'Table Layout',
        'plural' => 'Table Layout',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Table Layout',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
    'fields' => [
        'id' => [
            'label' => 'Identificativo',
            'tooltip' => 'Identificativo univoco del record',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
        ],
        'updated_at' => [
            'label' => 'Ultima Modifica',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Table Layout',
        ],
        'edit' => [
            'label' => 'Modifica Table Layout',
        ],
        'delete' => [
            'label' => 'Elimina Table Layout',
        ],
    ],
];
