<?php

declare(strict_types=1);

return [
    'P1D' => [
        'label' => 'Giornaliero',
        'color' => 'info',
    ],
    'P1W' => [
        'label' => 'Settimanale',
        'color' => 'success',
    ],
    'P2W' => [
        'label' => 'Ogni 2 Settimane',
        'color' => 'warning',
    ],
    'P1M' => [
        'label' => 'Mensile',
        'color' => 'primary',
    ],
    'P1Y' => [
        'label' => 'Annuale',
        'color' => 'gray',
    ],
    'label' => 'Repeat Frequency',
    'plural_label' => 'Repeat Frequency (Plurale)',
    'navigation' => [
        'name' => 'Repeat Frequency',
        'plural' => 'Repeat Frequency',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Repeat Frequency',
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
            'label' => 'Crea Repeat Frequency',
        ],
        'edit' => [
            'label' => 'Modifica Repeat Frequency',
        ],
        'delete' => [
            'label' => 'Elimina Repeat Frequency',
        ],
    ],
];
