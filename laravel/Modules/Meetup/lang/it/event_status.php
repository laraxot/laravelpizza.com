<?php

declare(strict_types=1);

return [
    'draft' => [
        'label' => 'Bozza',
        'color' => 'gray',
    ],
    'EventScheduled' => [
        'label' => 'Programmato',
        'color' => 'success',
    ],
    'EventScheduled_confirmed' => [
        'label' => 'Confermato',
        'color' => 'success',
    ],
    'EventCancelled' => [
        'label' => 'Cancellato',
        'color' => 'danger',
    ],
    'EventPostponed' => [
        'label' => 'Rinviato',
        'color' => 'warning',
    ],
    'EventRescheduled' => [
        'label' => 'Riprogrammato',
        'color' => 'info',
    ],
    'EventMovedOnline' => [
        'label' => 'Spostato Online',
        'color' => 'primary',
    ],
    'completed' => [
        'label' => 'Completato',
        'color' => 'success',
    ],
    'label' => 'Event Status',
    'plural_label' => 'Event Status (Plurale)',
    'navigation' => [
        'name' => 'Event Status',
        'plural' => 'Event Status',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Event Status',
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
            'label' => 'Crea Event Status',
        ],
        'edit' => [
            'label' => 'Modifica Event Status',
        ],
        'delete' => [
            'label' => 'Elimina Event Status',
        ],
    ],
];
