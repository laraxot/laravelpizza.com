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
                'sort' => 20,
                'icon' => 'ui-geo-location',
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
    'label' => 'Geo',
    'plural_label' => 'Geo (Plurale)',
    'fields' => [
        'id' => [
            'label' => 'Identificativo',
            'tooltip' => 'Identificativo univoco del record',
            'helper_text' => '',
            'description' => '',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'updated_at' => [
            'label' => 'Ultima Modifica',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Geo',
        ],
        'edit' => [
            'label' => 'Modifica Geo',
        ],
        'delete' => [
            'label' => 'Elimina Geo',
        ],
    ],

    // Coordinate Picker - Map Controls
    'coordinate-picker' => [
        'search_placeholder' => 'Cerca un luogo...',
        'use_my_location' => 'Usa la mia posizione',
        'locating' => 'Localizzando...',
        'no_position' => 'Clicca sulla mappa per indicare la posizione',
        'latitude' => 'Latitudine',
        'longitude' => 'Longitudine',
        'city' => 'Città',
        'fullscreen' => 'Schermo intero',
        'close_fullscreen' => 'Esci da schermo intero',
        'zoom_in' => 'Aumenta zoom',
        'zoom_out' => 'Diminuisci zoom',
        'layers' => [
            'street' => 'Stradale (OSM)',
            'humanitarian' => 'Umanitaria (OSM)',
            'satellite' => 'Satellitare (Esri)',
            'terrain' => 'Terreno (Topo)',
            'topographic' => 'Topografica (Esri)',
        ],
        'address_found' => 'Indirizzo trovato',
        'location_error' => 'Impossibile ottenere la posizione',
        'location_denied' => 'Permesso posizione negato',
        'geocode_error' => 'Indirizzo non trovato',
        'search_results' => 'Risultati ricerca',
        'no_results' => 'Nessun risultato',
        'coordinates_set' => 'Coordinate impostate',
    ],
];
