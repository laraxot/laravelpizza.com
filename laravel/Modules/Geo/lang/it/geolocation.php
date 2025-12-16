<?php

declare(strict_types=1);

return [
    'fields' => [
        'ip_address' => [
            'label' => 'Indirizzo IP',
            'placeholder' => 'Inserisci l\'indirizzo IP',
            'help' => 'Indirizzo IP da geolocalizzare',
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
        'accuracy' => [
            'label' => 'Precisione',
            'placeholder' => 'Seleziona la precisione',
            'help' => 'Livello di precisione della geolocalizzazione',
        ],
        'provider' => [
            'label' => 'Provider',
            'placeholder' => 'Seleziona il provider',
            'help' => 'Servizio di geolocalizzazione da utilizzare',
        ],
        'country' => [
            'label' => 'Paese',
            'placeholder' => 'Seleziona il paese',
            'help' => 'Paese rilevato',
        ],
        'region' => [
            'label' => 'Regione',
            'placeholder' => 'Seleziona la regione',
            'help' => 'Regione rilevata',
        ],
        'city' => [
            'label' => 'Città',
            'placeholder' => 'Seleziona la città',
            'help' => 'Città rilevata',
        ],
        'timezone' => [
            'label' => 'Fuso orario',
            'placeholder' => 'Seleziona il fuso orario',
            'help' => 'Fuso orario rilevato',
        ],
    ],
    'validation' => [
        'ip_address_required' => 'L\'indirizzo IP è obbligatorio',
        'ip_address_invalid' => 'L\'indirizzo IP non è valido',
        'coordinates_invalid' => 'Le coordinate geografiche non sono valide',
        'provider_required' => 'Il provider è obbligatorio',
    ],
    'messages' => [
        'geolocation_success' => 'Geolocalizzazione completata con successo',
        'geolocation_failed' => 'Impossibile geolocalizzare l\'indirizzo IP',
        'batch_geolocation_success' => 'Geolocalizzazione batch completata con successo',
        'batch_geolocation_partial' => 'Geolocalizzazione batch completata parzialmente',
        'batch_geolocation_failed' => 'Geolocalizzazione batch fallita',
        'ip_updated' => 'Indirizzo IP aggiornato con successo',
        'location_updated' => 'Posizione aggiornata con successo',
    ],
    'errors' => [
        'invalid_ip' => 'Indirizzo IP non valido',
        'service_unavailable' => 'Servizio di geolocalizzazione non disponibile',
        'quota_exceeded' => 'Quota di geolocalizzazione esaurita',
        'rate_limit_exceeded' => 'Limite di richieste superato',
        'no_results_found' => 'Nessun risultato trovato',
        'private_ip' => 'Indirizzo IP privato non geolocalizzabile',
        'reserved_ip' => 'Indirizzo IP riservato non geolocalizzabile',
    ],
    'accuracy_levels' => [
        'country' => 'Paese',
        'region' => 'Regione',
        'city' => 'Città',
        'district' => 'Distretto',
        'street' => 'Via',
        'building' => 'Edificio',
    ],
];
