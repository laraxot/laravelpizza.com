<?php

declare(strict_types=1);

return [
    'label' => 'Giorno della Settimana',
    'options' => [
        1 => 'Lunedì',
        2 => 'Martedì',
        3 => 'Mercoledì',
        4 => 'Giovedì',
        5 => 'Venerdì',
        6 => 'Sabato',
        7 => 'Domenica',
    ],
    'plural_label' => 'Day Of Week (Plurale)',
    'navigation' => [
        'name' => 'Day Of Week',
        'plural' => 'Day Of Week',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Day Of Week',
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
            'label' => 'Crea Day Of Week',
        ],
        'edit' => [
            'label' => 'Modifica Day Of Week',
        ],
        'delete' => [
            'label' => 'Elimina Day Of Week',
        ],
    ],
];
