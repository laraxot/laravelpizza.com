<?php

declare(strict_types=1);

return [
    'navigation' => [
        'icons' => [
            'location-map' => [
                'default' => 'heroicon-o-map-pin',
                'hover' => 'heroicon-o-map-pin animate-bounce',
                'title' => 'Location icon',
            ],
            'lat-lng' => [
                'default' => 'heroicon-o-map-pin',
                'hover' => 'heroicon-o-map-pin animate-pulse',
                'title' => 'Coordinates icon',
            ],
            'webbingbrasil-map' => [
                'default' => 'heroicon-o-map',
                'hover' => 'heroicon-o-map animate-spin',
                'title' => 'Webbingbrasil map icon',
            ],
            'osm-map' => [
                'default' => 'heroicon-o-globe-alt',
                'hover' => 'heroicon-o-globe-alt animate-spin',
                'title' => 'Global map icon',
            ],
            'dotswan-map' => [
                'default' => 'heroicon-o-map',
                'hover' => 'heroicon-o-map animate-spin',
                'title' => 'Dotswan map icon',
            ],
            'setting-page' => [
                'default' => 'heroicon-o-cog-6-tooth',
                'hover' => 'heroicon-o-cog-6-tooth animate-spin',
                'title' => 'Settings icon',
            ],
        ],
        'groups' => [
            'geo' => [
                'name' => 'Geo',
                'description' => 'Maps and location management',
            ],
        ],
        'pages' => [
            'location-map' => [
                'label' => 'Location Map',
                'description' => 'View and manage locations on the map',
                'sort' => '1',
            ],
            'lat-lng' => [
                'label' => 'Coordinates',
                'description' => 'Geographic coordinates management',
                'sort' => '2',
            ],
            'webbingbrasil-map' => [
                'label' => 'Webbingbrasil Map',
                'description' => 'Map view with Webbingbrasil',
                'sort' => '3',
            ],
            'osm-map' => [
                'label' => 'OSM Map',
                'description' => 'OpenStreetMap view',
                'sort' => '4',
            ],
            'dotswan-map' => [
                'label' => 'Dotswan Map',
                'description' => 'Map view with Dotswan',
                'sort' => '5',
            ],
            'setting-page' => [
                'label' => 'Settings',
                'description' => 'Geo module configuration',
                'sort' => '6',
            ],
        ],
        'name' => 'Geo',
        'group' => 'Mappe',
        'sort' => '20',
        'icon' => 'ui-geo-menu',
        'badge' => [
            'color' => 'success',
            'label' => 'Online',
        ],
    ],
    'status' => [
        'waiting' => 'Waiting...',
        'loading' => 'Loading...',
        'error' => 'Error',
        'success' => 'Completed',
    ],
    'actions' => [
        'save' => 'Save',
        'cancel' => 'Cancel',
        'delete' => 'Delete',
        'edit' => 'Edit',
        'view' => 'View',
    ],
    'messages' => [
        'saved' => 'Successfully saved',
        'deleted' => 'Successfully deleted',
        'error' => 'An error occurred',
    ],
    'sections' => [
        'map' => [
            'navigation' => [
                'name' => 'Mappa',
                'group' => 'Geo',
                'sort' => '10',
                'icon' => 'ui-geo-map',
                'badge' => [
                    'color' => 'info',
                    'label' => 'Interattiva',
                ],
            ],
            'fields' => [
                'zoom' => 'Livello Zoom',
                'center' => 'Centro Mappa',
                'type' => 'Tipo Mappa',
                'markers' => 'Marcatori',
                'bounds' => 'Confini',
            ],
            'types' => [
                'roadmap' => 'Stradale',
                'satellite' => 'Satellite',
                'hybrid' => 'Ibrida',
                'terrain' => 'Terreno',
            ],
        ],
        'location' => [
            'navigation' => [
                'name' => 'Posizioni',
                'group' => 'Geo',
                'sort' => '20',
                'icon' => 'ui-geo-location',
                'badge' => [
                    'color' => 'warning',
                    'label' => 'Da Verificare',
                ],
            ],
            'fields' => [
                'name' => 'Name',
                'address' => 'Indirizzo',
                'latitude' => 'Latitudine',
                'longitude' => 'Longitudine',
                'category' => 'Categoria',
                'status' => 'Stato',
            ],
            'categories' => [
                'business' => 'Attività',
                'residence' => 'Residenza',
                'point_of_interest' => 'Punto di Interesse',
                'public_service' => 'Servizio Public',
            ],
        ],
    ],
    'common' => [
        'status' => [
            'active' => 'Active',
            'inactive' => 'Inactive',
            'pending' => 'In Attesa',
            'verified' => 'Verified',
        ],
        'actions' => [
            'locate' => 'Localizza',
            'center' => 'Centra Mappa',
            'zoom' => 'Zoom',
            'pan' => 'Sposta',
            'measure' => 'Misura',
            'directions' => 'Indicazioni',
        ],
        'messages' => [
            'success' => [
                'located' => 'Location found',
                'saved' => 'Location saved',
                'updated' => 'Location updated',
                'deleted' => 'Location deleted',
            ],
            'error' => [
                'not_found' => 'Location not found',
                'invalid_coords' => 'Invalid coordinates',
                'geocoding_failed' => 'Geocoding failed',
                'network_error' => 'Network error',
            ],
        ],
        'filters' => [
            'radius' => 'Raggio',
            'category' => 'Categoria',
            'status' => 'Stato',
            'date_range' => 'Periodo',
        ],
    ],
];
