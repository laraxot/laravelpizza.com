<?php

declare(strict_types=1);

return [
    'fields' => [
        'use_my_location' => [
            'label' => 'Usa la tua posizione',
        ],
        'address' => [
            'label' => 'Luogo',
            'placeholder' => 'Cerca un luogo',
            'use_my_location' => 'Usa la tua posizione',
        ],
    ],
    'geolocation' => [
        'locating' => 'Rilevamento posizione in corso...',
        'not_supported' => 'Geolocalizzazione non supportata dal browser.',
        'address_not_found' => 'Indirizzo non trovato.',
        'error' => 'Errore durante la geolocalizzazione.',
        'permission_denied' => 'Permesso di geolocalizzazione negato.',
        'timeout' => 'Timeout durante il rilevamento della posizione.',
        'unavailable' => 'Posizione non disponibile al momento.',
    ],
    'validation' => [
        'required' => 'L\'indirizzo è obbligatorio.',
        'max' => 'L\'indirizzo non può superare :max caratteri.',
    ],
];
