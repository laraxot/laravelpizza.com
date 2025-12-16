<?php

declare(strict_types=1);

return [
    'fields' => [
        'name' => [
            'label' => 'Nome provincia',
            'placeholder' => 'Inserisci il nome della provincia',
            'help' => 'Nome ufficiale della provincia',
        ],
        'code' => [
            'label' => 'Sigla',
            'placeholder' => 'Inserisci la sigla della provincia',
            'help' => 'Sigla della provincia (es. RM, MI, TO)',
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
        'capital' => [
            'label' => 'Capoluogo',
            'placeholder' => 'Inserisci il capoluogo',
            'help' => 'Capoluogo della provincia',
        ],
        'population' => [
            'label' => 'Popolazione',
            'placeholder' => 'Inserisci il numero di abitanti',
            'help' => 'Numero di abitanti della provincia',
        ],
        'area' => [
            'label' => 'Superficie',
            'placeholder' => 'Inserisci la superficie in km²',
            'help' => 'Superficie della provincia in chilometri quadrati',
        ],
        'is_active' => [
            'label' => 'Attiva',
            'help' => 'Indica se la provincia è attiva nel sistema',
        ],
    ],
    'validation' => [
        'name_required' => 'Il nome della provincia è obbligatorio',
        'code_required' => 'La sigla della provincia è obbligatoria',
        'code_unique' => 'La sigla della provincia deve essere unica',
        'region_required' => 'La regione è obbligatoria',
        'country_required' => 'Il paese è obbligatorio',
    ],
    'messages' => [
        'province_created' => 'Provincia creata con successo',
        'province_updated' => 'Provincia aggiornata con successo',
        'province_deleted' => 'Provincia eliminata con successo',
        'province_activated' => 'Provincia attivata con successo',
        'province_deactivated' => 'Provincia disattivata con successo',
    ],
];
