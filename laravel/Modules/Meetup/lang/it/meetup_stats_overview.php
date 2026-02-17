<?php

declare(strict_types=1);

return [
    'sections' => [
        'empty' => [
            'label' => 'empty',
            'heading' => 'empty',
        ],
    ],
    'label' => 'Meetup Stats Overview',
    'plural_label' => 'Meetup Stats Overview (Plurale)',
    'navigation' => [
        'name' => 'Meetup Stats Overview',
        'plural' => 'Meetup Stats Overview',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Meetup Stats Overview',
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
            'label' => 'Crea Meetup Stats Overview',
        ],
        'edit' => [
            'label' => 'Modifica Meetup Stats Overview',
        ],
        'delete' => [
            'label' => 'Elimina Meetup Stats Overview',
        ],
    ],
];
