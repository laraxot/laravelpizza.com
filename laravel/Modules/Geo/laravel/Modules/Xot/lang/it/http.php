<?php

declare(strict_types=1);

return [
    404 => [
        'title' => 'Pagina Non Trovata',
        'description' => 'Spiacenti, la pagina che stavi cercando di visualizzare non esiste.',
    ],
    503 => [
        'title' => 'Torniamo subito.',
        'description' => 'Torniamo subito.',
    ],
    'label' => 'Http',
    'plural_label' => 'Http (Plurale)',
    'navigation' => [
        'name' => 'Http',
        'plural' => 'Http',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Http',
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
            'label' => 'Crea Http',
        ],
        'edit' => [
            'label' => 'Modifica Http',
        ],
        'delete' => [
            'label' => 'Elimina Http',
        ],
    ],
];
