<?php

declare(strict_types=1);

return [
    'fields' => [
        'text' => [
            'label' => 'Testo',
            'tooltip' => '',
        ],
        'level' => [
            'label' => 'Grandezza',
            'tooltip' => '',
        ],
        '_tpl' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'view' => [
            'tooltip' => '',
        ],
    ],
    'label' => 'Title',
    'plural_label' => 'Title (Plurale)',
    'navigation' => [
        'name' => 'Title',
        'plural' => 'Title',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Title',
        'sort' => 1,
        'icon' => 'heroicon-o-rectangle-stack',
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Title',
        ],
        'edit' => [
            'label' => 'Modifica Title',
        ],
        'delete' => [
            'label' => 'Elimina Title',
        ],
    ],
];
