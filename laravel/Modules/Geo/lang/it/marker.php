<?php

declare(strict_types=1);

return [
    'fields' => [
        'title' => [
            'label' => 'Titolo',
            'placeholder' => 'Inserisci il titolo del marcatore',
            'help' => 'Titolo identificativo del marcatore',
        ],
        'description' => [
            'label' => 'Descrizione',
            'placeholder' => 'Inserisci una descrizione',
            'help' => 'Descrizione dettagliata del marcatore',
        ],
        'latitude' => [
            'label' => 'Latitudine',
            'placeholder' => 'Inserisci la latitudine',
            'help' => 'Coordinate geografiche - latitudine',
        ],
        'longitude' => [
            'label' => 'Longitudine',
            'placeholder' => 'Inserisci la longitudine',
            'help' => 'Coordinate geografiche - longitudine',
        ],
        'icon' => [
            'label' => 'Icona',
            'placeholder' => 'Seleziona l\'icona',
            'help' => 'Icona da visualizzare per il marcatore',
        ],
        'color' => [
            'label' => 'Colore',
            'placeholder' => 'Seleziona il colore',
            'help' => 'Colore del marcatore',
        ],
        'is_draggable' => [
            'label' => 'Trascinabile',
            'help' => 'Permette di trascinare il marcatore',
        ],
        'is_clickable' => [
            'label' => 'Cliccabile',
            'help' => 'Permette di cliccare sul marcatore',
        ],
        'show_info_window' => [
            'label' => 'Mostra finestra info',
            'help' => 'Mostra la finestra informativa al click',
        ],
    ],
    'validation' => [
        'title_required' => 'Il titolo è obbligatorio',
        'latitude_required' => 'La latitudine è obbligatoria',
        'longitude_required' => 'La longitudine è obbligatoria',
        'coordinates_invalid' => 'Le coordinate geografiche non sono valide',
    ],
    'messages' => [
        'marker_created' => 'Marcatore creato con successo',
        'marker_updated' => 'Marcatore aggiornato con successo',
        'marker_deleted' => 'Marcatore eliminato con successo',
        'marker_moved' => 'Marcatore spostato con successo',
        'marker_icon_changed' => 'Icona del marcatore cambiata con successo',
    ],
    'icon_types' => [
        'default' => 'Predefinito',
        'home' => 'Casa',
        'work' => 'Lavoro',
        'shop' => 'Negozio',
        'restaurant' => 'Ristorante',
        'hotel' => 'Hotel',
        'hospital' => 'Ospedale',
        'school' => 'Scuola',
        'park' => 'Parco',
        'custom' => 'Personalizzato',
    ],
];
