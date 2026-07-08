<?php

declare(strict_types=1);

return [
    'list' => [
        'label' => 'Lista',
        'color' => 'primary',
        'icon' => 'heroicon-o-list-bullet',
        'description' => 'Layout a lista tradizionale con righe di tabella',
        'tooltip' => 'Visualizza i dati in formato tabella strutturata',
        'helper_text' => 'Ideale per visualizzare molti dati in modo organizzato',
    ],
    'grid' => [
        'label' => 'Griglia',
        'color' => 'secondary',
        'icon' => 'heroicon-o-squares-2x2',
        'description' => 'Layout a griglia responsive con card',
        'tooltip' => 'Visualizza i dati in formato card responsive',
        'helper_text' => 'Ideale per visualizzare pochi dati con focus visivo',
    ],
    'label' => 'Table Layout Enum',
    'plural_label' => 'Table Layout Enum (Plurale)',
    'navigation' => [
        'name' => 'Table Layout Enum',
        'plural' => 'Table Layout Enum',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Table Layout Enum',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
    'fields' => [
        'id' => [
            'label' => 'Identificativo',
            'tooltip' => 'Identificativo univoco del record',
            'helper_text' => '',
            'description' => '',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'updated_at' => [
            'label' => 'Ultima Modifica',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Table Layout Enum',
        ],
        'edit' => [
            'label' => 'Modifica Table Layout Enum',
        ],
        'delete' => [
            'label' => 'Elimina Table Layout Enum',
        ],
    ],
];
