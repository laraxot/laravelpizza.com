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
        ],
    ],
];
