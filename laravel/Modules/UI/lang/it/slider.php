<?php

declare(strict_types=1);

return [
    'fields' => [
        'method' => [
            'label' => 'method',
            'description' => 'method',
            'helper_text' => 'method',
            'placeholder' => 'method',
        ],
        '_tpl' => [
            'label' => '_tpl',
        ],
        'view' => [
            'label' => 'view',
        ],
    ],
    'label' => 'Slider',
    'plural_label' => 'Slider (Plurale)',
    'navigation' => [
        'name' => 'Slider',
        'plural' => 'Slider',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Slider',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Slider',
        ],
        'edit' => [
            'label' => 'Modifica Slider',
        ],
        'delete' => [
            'label' => 'Elimina Slider',
        ],
    ],
];
