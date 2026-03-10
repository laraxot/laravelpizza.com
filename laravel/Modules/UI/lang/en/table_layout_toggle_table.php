<?php

declare(strict_types=1);

return [
    'actions' => [
        'toggle' => [
            'label' => 'Toggle Table Layout',
        ],
    ],
    'table_layout' => [
        'actions' => [
            'toggle' => [
                'label' => 'Toggle Layout',
                'tooltip' => 'Switch between list and grid view',
                'helper_text' => 'Change the display type',
            ],
        ],
    ],
    'fields' => [
        'layout' => [
            'label' => 'Layout',
            'placeholder' => 'Select layout type',
            'tooltip' => 'Choose between list and grid view',
            'help' => 'Choose the most suitable layout type to display the data',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'navigation' => [
        'label' => 'Missing Navigation Label',
        'plural_label' => 'Missing Navigation Plural Label',
        'group' => 'Missing Group',
        'icon' => 'heroicon-o-puzzle-piece',
        'sort' => 100,
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
];
