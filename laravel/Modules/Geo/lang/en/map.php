<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Mappe',
        'plural' => 'Mappe',
        'group' => [
            'name' => 'Geo',
            'description' => 'Manage and view maps',
        ],
        'label' => 'Mappe',
        'sort' => '33',
        'icon' => 'ui-geo-map',
    ],
    'fields' => [
        'title' => [
            'label' => 'Title',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'type' => [
            'label' => 'Map Type',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'zoom_level' => [
            'label' => 'Livello Zoom',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'center_lat' => [
            'label' => 'Latitudine Centro',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'center_lng' => [
            'label' => 'Longitudine Centro',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'markers' => [
            'label' => 'Marcatori',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'layers' => [
            'label' => 'Livelli',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'style' => [
            'label' => 'Stile',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'map_types' => [
        'roadmap' => 'Stradale',
        'satellite' => 'Satellite',
        'hybrid' => 'Ibrida',
        'terrain' => 'Terreno',
    ],
    'controls' => [
        'zoom' => 'Zoom',
        'pan' => 'Panoramica',
        'fullscreen' => 'Schermo Intero',
        'streetview' => 'Street View',
        'layers' => 'Livelli',
    ],
    'actions' => [
        'add_marker' => 'Add Marker',
        'draw_polygon' => 'Disegna Poligono',
        'measure_distance' => 'Misura Distanza',
        'export' => 'Export',
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
];
