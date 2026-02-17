<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Dashboard Meetup',
        'group' => 'Meetups',
        'icon' => 'heroicon-o-chart-bar',
        'sort' => 10,
    ],
    'label' => 'Meetup Dashboard',
    'plural_label' => 'Meetup Dashboard (Plurale)',
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
            'label' => 'Crea Meetup Dashboard',
        ],
        'edit' => [
            'label' => 'Modifica Meetup Dashboard',
        ],
        'delete' => [
            'label' => 'Elimina Meetup Dashboard',
        ],
    ],
];
