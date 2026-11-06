<?php

declare(strict_types=1);

/**
 * Address component translations.
 *
 * Used by: AddressInput (Geo module), CreateTicketWizardWidget (Fixcity module)
 * Namespace: geo::address.* (fallback) or fixcity::create_ticket_wizard.fields.address.*
 */
return [
    'fields' => [
        'use_my_location' => [
            'label' => 'Use my location',
        ],
        'address' => [
            'label' => 'Location',
            'placeholder' => 'Search for a location',
            'use_my_location' => 'Use my location',
        ],
    ],
    'geolocation' => [
        'locating' => 'Detecting your location...',
        'not_supported' => 'Geolocation is not supported by your browser.',
        'address_not_found' => 'Address not found.',
        'error' => 'Error during geolocation.',
        'permission_denied' => 'Geolocation permission denied.',
        'timeout' => 'Location detection timed out.',
        'unavailable' => 'Location is currently unavailable.',
    ],
    'validation' => [
        'required' => 'The address is required.',
        'max' => 'The address may not be greater than :max characters.',
    ],
];
