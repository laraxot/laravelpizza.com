<?php

declare(strict_types=1);

return [
    'fields' => [
        'view' => [
            'label' => 'Visualizzazione',
            'tooltip' => 'Seleziona la visualizzazione da mostrare',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'updateAction' => [
            'label' => 'Aggiorna Footer',
            'tooltip' => 'Aggiorna le impostazioni del footer',
            'icon' => 'heroicon-o-pencil',
            'color' => 'primary',
        ],
    ],
    'label' => 'Footer',
    'plural_label' => 'Footer (Plurale)',
    'navigation' => [
        'name' => 'Footer',
        'plural' => 'Footer',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Footer',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
];
