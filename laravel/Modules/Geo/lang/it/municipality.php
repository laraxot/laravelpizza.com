<?php

declare(strict_types=1);

return [
    'fields' => [
        'name' => [
            'label' => 'Nome comune',
            'placeholder' => 'Inserisci il nome del comune',
            'help' => 'Nome ufficiale del comune',
        ],
        'code' => [
            'label' => 'Codice ISTAT',
            'placeholder' => 'Inserisci il codice ISTAT',
            'help' => 'Codice ISTAT del comune',
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
            'help' => 'Numero di abitanti del comune',
        ],
        'area' => [
            'label' => 'Superficie',
            'placeholder' => 'Inserisci la superficie in km²',
            'help' => 'Superficie del comune in chilometri quadrati',
        ],
        'is_active' => [
            'label' => 'Attivo',
            'help' => 'Indica se il comune è attivo nel sistema',
        ],
    ],
    'validation' => [
        'name_required' => 'Il nome del comune è obbligatorio',
        'code_required' => 'Il codice ISTAT è obbligatorio',
        'code_unique' => 'Il codice ISTAT deve essere unico',
        'province_required' => 'La provincia è obbligatoria',
        'region_required' => 'La regione è obbligatoria',
        'country_required' => 'Il paese è obbligatorio',
    ],
    'messages' => [
        'municipality_created' => 'Comune creato con successo',
        'municipality_updated' => 'Comune aggiornato con successo',
        'municipality_deleted' => 'Comune eliminato con successo',
        'municipality_activated' => 'Comune attivato con successo',
        'municipality_deactivated' => 'Comune disattivato con successo',
    ],
];
