<?php

declare(strict_types=1);

return [
    'fields' => [
        'name' => [
            'label' => 'Nome città',
            'placeholder' => 'Inserisci il nome della città',
            'help' => 'Nome ufficiale della città',
        ],
        'province' => [
            'label' => 'Provincia',
            'placeholder' => 'Seleziona la provincia',
            'help' => 'Provincia di appartenenza',
        ],
        'region' => [
            'label' => 'Regione',
            'placeholder' => 'Seleziona la regione',
            'help' => 'Regione di appartenenza',
        ],
        'country' => [
            'label' => 'Paese',
            'placeholder' => 'Seleziona il paese',
            'help' => 'Paese di appartenenza',
        ],
        'postal_code' => [
            'label' => 'CAP',
            'placeholder' => 'Inserisci il CAP',
            'help' => 'Codice di avviamento postale',
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
        'population' => [
            'label' => 'Popolazione',
            'placeholder' => 'Inserisci il numero di abitanti',
            'help' => 'Numero di abitanti della città',
        ],
        'area' => [
            'label' => 'Superficie',
            'placeholder' => 'Inserisci la superficie in km²',
            'help' => 'Superficie della città in chilometri quadrati',
        ],
    ],
    'validation' => [
        'name_required' => 'Il nome della città è obbligatorio',
        'province_required' => 'La provincia è obbligatoria',
        'region_required' => 'La regione è obbligatoria',
        'country_required' => 'Il paese è obbligatorio',
        'coordinates_invalid' => 'Le coordinate geografiche non sono valide',
    ],
    'messages' => [
        'city_created' => 'Città creata con successo',
        'city_updated' => 'Città aggiornata con successo',
        'city_deleted' => 'Città eliminata con successo',
        'geocoding_success' => 'Geocoding completato con successo',
        'geocoding_error' => 'Errore durante il geocoding',
    ],
];
