<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Geo',
        'group' => 'Mappe',
        'sort' => 20,
        'icon' => 'ui-geo-menu',
        'badge' => [
            'color' => 'success',
            'label' => 'Online',
        ],
    ],
    'sections' => [
        'map' => [
            'navigation' => [
                'name' => 'Mappa',
                'group' => 'Geo',
                'sort' => 10,
                'icon' => 'ui-geo-map', // Questo è già corretto
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
                'sort' => 20,
                'icon' => 'ui-geo-location', // Questo è già corretto
                'badge' => [
                    'color' => 'warning',
                    'label' => 'Da Verificare',
                ],
            ],
            'fields' => [
                'name' => 'Nome',
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
                'public_service' => 'Servizio Pubblico',
            ],
        ],
    ],
    'common' => [
        'status' => [
            'active' => 'Attivo',
            'inactive' => 'Inattivo',
            'pending' => 'In Attesa',
            'verified' => 'Verificato',
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
                'located' => 'Posizione trovata',
                'saved' => 'Posizione salvata',
                'updated' => 'Posizione aggiornata',
                'deleted' => 'Posizione eliminata',
            ],
            'error' => [
                'not_found' => 'Posizione non trovata',
                'invalid_coords' => 'Coordinate non valide',
                'geocoding_failed' => 'Geocodifica fallita',
                'network_error' => 'Errore di rete',
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
