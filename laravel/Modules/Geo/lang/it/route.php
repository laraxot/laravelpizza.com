<?php

declare(strict_types=1);

return [
    'fields' => [
        'name' => [
            'label' => 'Nome percorso',
            'placeholder' => 'Inserisci il nome del percorso',
            'help' => 'Nome identificativo del percorso',
        ],
        'description' => [
            'label' => 'Descrizione',
            'placeholder' => 'Inserisci una descrizione',
            'help' => 'Descrizione dettagliata del percorso',
        ],
        'start_point' => [
            'label' => 'Punto di partenza',
            'placeholder' => 'Seleziona il punto di partenza',
            'help' => 'Punto di inizio del percorso',
        ],
        'end_point' => [
            'label' => 'Punto di arrivo',
            'placeholder' => 'Seleziona il punto di arrivo',
            'help' => 'Punto di destinazione del percorso',
        ],
        'waypoints' => [
            'label' => 'Punti intermedi',
            'placeholder' => 'Aggiungi punti intermedi',
            'help' => 'Punti intermedi del percorso',
        ],
        'transport_mode' => [
            'label' => 'Modalità di trasporto',
            'placeholder' => 'Seleziona la modalità',
            'help' => 'Mezzo di trasporto per il percorso',
        ],
        'avoid_tolls' => [
            'label' => 'Evita pedaggi',
            'help' => 'Evita strade a pedaggio',
        ],
        'avoid_highways' => [
            'label' => 'Evita autostrade',
            'help' => 'Evita le autostrade',
        ],
        'optimize_waypoints' => [
            'label' => 'Ottimizza punti intermedi',
            'help' => 'Ottimizza l\'ordine dei punti intermedi',
        ],
    ],
    'validation' => [
        'name_required' => 'Il nome del percorso è obbligatorio',
        'start_point_required' => 'Il punto di partenza è obbligatorio',
        'end_point_required' => 'Il punto di arrivo è obbligatorio',
        'transport_mode_required' => 'La modalità di trasporto è obbligatoria',
    ],
    'messages' => [
        'route_created' => 'Percorso creato con successo',
        'route_updated' => 'Percorso aggiornato con successo',
        'route_deleted' => 'Percorso eliminato con successo',
        'route_calculated' => 'Percorso calcolato con successo',
        'route_calculation_failed' => 'Impossibile calcolare il percorso',
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
    'route_info' => [
        'distance' => 'Distanza',
        'duration' => 'Durata',
        'duration_traffic' => 'Durata con traffico',
        'toll_roads' => 'Strade a pedaggio',
        'highways' => 'Autostrade',
        'ferries' => 'Traghetti',
        'indoor' => 'Indoor',
    ],
];
