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
        'name' => [
            'label' => 'name',
            'placeholder' => 'name',
            'helper_text' => 'name',
            'description' => 'name',
        ],
        'country' => [
            'label' => 'country',
            'placeholder' => 'country',
            'helper_text' => 'country',
            'description' => 'country',
        ],
        'administrative_area_level_1' => [
            'label' => 'administrative_area_level_1',
            'placeholder' => 'administrative_area_level_1',
            'helper_text' => 'administrative_area_level_1',
            'description' => 'administrative_area_level_1',
        ],
        'administrative_area_level_2' => [
            'label' => 'administrative_area_level_2',
            'placeholder' => 'administrative_area_level_2',
            'helper_text' => 'administrative_area_level_2',
            'description' => 'administrative_area_level_2',
        ],
        'locality' => [
            'label' => 'locality',
            'placeholder' => 'locality',
            'helper_text' => 'locality',
            'description' => 'locality',
        ],
        'postal_code' => [
            'label' => 'postal_code',
            'placeholder' => 'postal_code',
            'helper_text' => 'postal_code',
            'description' => 'postal_code',
        ],
        'route' => [
            'label' => 'route',
            'placeholder' => 'route',
            'helper_text' => 'route',
            'description' => 'route',
        ],
        'street_number' => [
            'label' => 'street_number',
            'placeholder' => 'street_number',
            'helper_text' => 'street_number',
            'description' => 'street_number',
        ],
        'is_primary' => [
            'label' => 'is_primary',
            'placeholder' => 'is_primary',
            'helper_text' => 'is_primary',
            'description' => 'is_primary',
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
