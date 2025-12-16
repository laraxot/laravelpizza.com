<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Mappe',
        'plural' => 'Mappe',
        'group' => [
            'name' => 'Geo',
            'description' => 'Gestione e visualizzazione delle mappe',
        ],
        'label' => 'Mappe',
        'sort' => 33,
        'icon' => 'ui-geo-map',
    ],
    'fields' => [
        'title' => 'Titolo',
        'type' => 'Tipo Mappa',
        'zoom_level' => 'Livello Zoom',
        'center_lat' => 'Latitudine Centro',
        'center_lng' => 'Longitudine Centro',
        'markers' => 'Marcatori',
        'layers' => 'Livelli',
        'style' => 'Stile',
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
        'add_marker' => 'Aggiungi Marcatore',
        'draw_polygon' => 'Disegna Poligono',
        'measure_distance' => 'Misura Distanza',
        'export' => 'Esporta',
    ],
];
