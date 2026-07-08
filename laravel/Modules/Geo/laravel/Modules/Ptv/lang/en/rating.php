<?php

declare(strict_types=1);

return [
    'resource' => [
        'name' => 'Rating',
    ],
    'navigation' => [
        'name' => 'Rating',
        'plural' => 'Ratings',
        'group' => [
            'name' => 'Admin',
        ],
    ],
    'fields' => [
        'name' => ['label' => 'Name'],
    ],
    'actions' => [
        'enable' => [
            'cta' => 'Enable',
        ],
        'disable' => [
            'cta' => 'Disable',
        ],
    ],
];
