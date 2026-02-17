<?php

declare(strict_types=1);

return [
    'fields' => [
        'title' => [
            'label' => 'Titolo',
            'placeholder' => 'Inserisci il titolo del marcatore',
            'help' => 'Titolo identificativo del marcatore',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'description' => [
            'label' => 'Descrizione',
            'placeholder' => 'Inserisci una descrizione',
            'help' => 'Descrizione dettagliata del marcatore',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'latitude' => [
            'label' => 'Latitudine',
            'placeholder' => 'Inserisci la latitudine',
            'help' => 'Coordinate geografiche - latitudine',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'longitude' => [
            'label' => 'Longitudine',
            'placeholder' => 'Inserisci la longitudine',
            'help' => 'Coordinate geografiche - longitudine',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'icon' => [
            'label' => 'Icona',
            'placeholder' => 'Seleziona l\'icona',
            'help' => 'Icona da visualizzare per il marcatore',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'color' => [
            'label' => 'Colore',
            'placeholder' => 'Seleziona il colore',
            'help' => 'Colore del marcatore',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'is_draggable' => [
            'label' => 'Trascinabile',
            'help' => 'Permette di trascinare il marcatore',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'is_clickable' => [
            'label' => 'Cliccabile',
            'help' => 'Permette di cliccare sul marcatore',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'show_info_window' => [
            'label' => 'Mostra finestra info',
            'help' => 'Mostra la finestra informativa al click',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
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
    'label' => 'Marker',
    'plural_label' => 'Marker (Plurale)',
    'navigation' => [
        'name' => 'Marker',
        'plural' => 'Marker',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Marker',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Marker',
        ],
        'edit' => [
            'label' => 'Modifica Marker',
        ],
        'delete' => [
            'label' => 'Elimina Marker',
        ],
    ],
];
