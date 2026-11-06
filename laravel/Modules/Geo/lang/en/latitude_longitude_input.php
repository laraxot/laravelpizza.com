<?php

declare(strict_types=1);

return [
    'actions' => [
        'fullscreen_enter' => 'View fullscreen',
        'fullscreen_exit' => 'Exit fullscreen',
    ],
    'layers' => [
        'osm' => 'Map',
        'satellite' => 'Satellite',
        'terrain' => 'Terrain',
    ],
    'fields' => [
        'latitude' => [
            'label' => 'latitude',
            'placeholder' => 'latitude',
            'helper_text' => 'latitude',
            'description' => 'latitude',
        ],
        'longitude' => [
            'label' => 'longitude',
            'placeholder' => 'longitude',
            'helper_text' => 'longitude',
            'description' => 'longitude',
        ],
    ],
];
