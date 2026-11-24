<?php

declare(strict_types=1);

return [
    'actions' => [
        'profile' => [
            'icon' => 'profile',
        ],
        'logout' => [
            'icon' => 'logout',
        ],
        'cancel' => [
            'icon' => 'cancel',
        ],
        'filter' => [
            'icon' => 'filter',
            'label' => 'Filtro',
        ],
    ],
    'fields' => [
        'endDate' => [
            'helper_text' => 'endDate3',
            'tooltip' => '',
        ],
        'startDate' => [
            'helper_text' => 'startDate1',
            'label' => 'startDate1',
            'tooltip' => '',
        ],
    ],
    'sections' => [
        'empty' => [
            'heading' => '',
            'label' => '',
        ],
    ],
    'navigation' => [
        'name' => 'View User',
        'plural' => 'View User',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'View User',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
    'label' => 'View User',
    'plural_label' => 'View User (Plurale)',
];
