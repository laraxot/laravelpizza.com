<?php

declare(strict_types=1);

return [
    'fields' => [
        'origin' => [
            'label' => 'Origine',
            'placeholder' => 'Seleziona il punto di origine',
            'help' => 'Punto di partenza per il calcolo della distanza',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'destination' => [
            'label' => 'Destinazione',
            'placeholder' => 'Seleziona il punto di destinazione',
            'help' => 'Punto di arrivo per il calcolo della distanza',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'waypoints' => [
            'label' => 'Punti intermedi',
            'placeholder' => 'Aggiungi punti intermedi',
            'help' => 'Punti intermedi per il calcolo della distanza',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'transport_mode' => [
            'label' => 'Modalità di trasporto',
            'placeholder' => 'Seleziona la modalità',
            'help' => 'Mezzo di trasporto per il calcolo',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'avoid_tolls' => [
            'label' => 'Evita pedaggi',
            'help' => 'Evita strade a pedaggio nel calcolo',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'avoid_highways' => [
            'label' => 'Evita autostrade',
            'help' => 'Evita le autostrade nel calcolo',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'optimize_waypoints' => [
            'label' => 'Ottimizza punti intermedi',
            'help' => 'Ottimizza l\'ordine dei punti intermedi',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'validation' => [
        'origin_required' => 'Il punto di origine è obbligatorio',
        'destination_required' => 'Il punto di destinazione è obbligatorio',
        'transport_mode_required' => 'La modalità di trasporto è obbligatoria',
    ],
    'messages' => [
        'distance_calculated' => 'Distanza calcolata con successo',
        'distance_calculation_failed' => 'Impossibile calcolare la distanza',
        'route_optimized' => 'Percorso ottimizzato con successo',
        'waypoint_added' => 'Punto intermedio aggiunto con successo',
        'waypoint_removed' => 'Punto intermedio rimosso con successo',
    ],
    'transport_modes' => [
        'driving' => 'Auto',
        'walking' => 'A piedi',
        'bicycling' => 'Bicicletta',
        'transit' => 'Trasporto pubblico',
        'flying' => 'Aereo',
    ],
    'distance_units' => [
        'km' => 'Chilometri',
        'm' => 'Metri',
        'mi' => 'Miglia',
        'ft' => 'Piedi',
        'yd' => 'Iarde',
    ],
    'duration_units' => [
        'hours' => 'Ore',
        'minutes' => 'Minuti',
        'seconds' => 'Secondi',
    ],
    'route_info' => [
        'total_distance' => 'Distanza totale',
        'total_duration' => 'Durata totale',
        'duration_traffic' => 'Durata con traffico',
        'toll_roads' => 'Strade a pedaggio',
        'highways' => 'Autostrade',
        'ferries' => 'Traghetti',
        'indoor' => 'Indoor',
    ],
    'label' => 'Distance',
    'plural_label' => 'Distance (Plurale)',
    'navigation' => [
        'name' => 'Distance',
        'plural' => 'Distance',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Distance',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Distance',
        ],
        'edit' => [
            'label' => 'Modifica Distance',
        ],
        'delete' => [
            'label' => 'Elimina Distance',
        ],
    ],
];
