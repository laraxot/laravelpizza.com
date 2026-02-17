<?php

declare(strict_types=1);

return [
    'actions' => [
        'profile' => [
            'label' => 'profile',
            'icon' => 'profile',
        ],
        'logout' => [
            'label' => 'logout',
            'icon' => 'logout',
        ],
        'cancel' => [
            'icon' => 'cancel',
        ],
        'filter' => [
            'icon' => 'filter',
            'label' => 'filter',
        ],
    ],
    'fields' => [
        'endDate' => [
            'description' => 'endDate',
            'helper_text' => 'endDate3',
            'placeholder' => 'endDate',
            'label' => 'endDate',
            'tooltip' => '',
        ],
        'startDate' => [
            'description' => 'startDate',
            'helper_text' => 'startDate1',
            'placeholder' => 'startDate',
            'label' => 'startDate1',
            'tooltip' => '',
        ],
    ],
    'sections' => [
        'empty' => [
            'heading' => 'empty',
            'label' => 'empty',
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
