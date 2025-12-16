<?php

declare(strict_types=1);

return [
    'fields' => [
        'name' => [
            'label' => 'Nome regione',
            'placeholder' => 'Inserisci il nome della regione',
            'help' => 'Nome ufficiale della regione',
        ],
        'code' => [
            'label' => 'Codice',
            'placeholder' => 'Inserisci il codice della regione',
            'help' => 'Codice identificativo della regione',
        ],
        'country' => [
            'label' => 'Paese',
            'placeholder' => 'Seleziona il paese',
            'help' => 'Paese di appartenenza',
        ],
        'capital' => [
            'label' => 'Capoluogo',
            'placeholder' => 'Inserisci il capoluogo',
            'help' => 'Capoluogo della regione',
        ],
        'population' => [
            'label' => 'Popolazione',
            'placeholder' => 'Inserisci il numero di abitanti',
            'help' => 'Numero di abitanti della regione',
        ],
        'area' => [
            'label' => 'Superficie',
            'placeholder' => 'Inserisci la superficie in km²',
            'help' => 'Superficie della regione in chilometri quadrati',
        ],
        'is_active' => [
            'label' => 'Attiva',
            'help' => 'Indica se la regione è attiva nel sistema',
        ],
    ],
    'validation' => [
        'name_required' => 'Il nome della regione è obbligatorio',
        'code_required' => 'Il codice della regione è obbligatorio',
        'code_unique' => 'Il codice della regione deve essere unico',
        'country_required' => 'Il paese è obbligatorio',
    ],
    'messages' => [
        'region_created' => 'Regione creata con successo',
        'region_updated' => 'Regione aggiornata con successo',
        'region_deleted' => 'Regione eliminata con successo',
        'region_activated' => 'Regione attivata con successo',
        'region_deactivated' => 'Regione disattivata con successo',
    ],
];
