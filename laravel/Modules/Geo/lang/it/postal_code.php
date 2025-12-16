<?php

declare(strict_types=1);

return [
    'fields' => [
        'code' => [
            'label' => 'CAP',
            'placeholder' => 'Inserisci il CAP',
            'help' => 'Codice di avviamento postale',
        ],
        'municipality' => [
            'label' => 'Comune',
            'placeholder' => 'Seleziona il comune',
            'help' => 'Comune di appartenenza',
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
        'is_active' => [
            'label' => 'Attivo',
            'help' => 'Indica se il CAP è attivo nel sistema',
        ],
    ],
    'validation' => [
        'code_required' => 'Il CAP è obbligatorio',
        'code_format' => 'Il CAP deve essere nel formato corretto',
        'municipality_required' => 'Il comune è obbligatorio',
        'province_required' => 'La provincia è obbligatoria',
        'region_required' => 'La regione è obbligatoria',
        'country_required' => 'Il paese è obbligatorio',
    ],
    'messages' => [
        'postal_code_created' => 'CAP creato con successo',
        'postal_code_updated' => 'CAP aggiornato con successo',
        'postal_code_deleted' => 'CAP eliminato con successo',
        'postal_code_activated' => 'CAP attivato con successo',
        'postal_code_deactivated' => 'CAP disattivato con successo',
    ],
];
