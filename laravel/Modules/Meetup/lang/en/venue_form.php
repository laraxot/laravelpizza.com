<?php

declare(strict_types=1);

// Etichette del form (VenueResource/Schemas/VenueForm, usato anche dal form evento).
return [
    'fields' => [
        'name' => [
            'label' => 'Name',
            'placeholder' => 'E.g. Talent Garden Calabiana',
            'helper_text' => 'The name of the venue or room.',
            'description' => '',
            'tooltip' => '',
        ],
        'address' => [
            'label' => 'Address',
            'placeholder' => '',
            'helper_text' => '',
            'description' => '',
            'tooltip' => '',
        ],
        'city' => [
            'label' => 'City',
            'placeholder' => 'E.g. Milan',
            'helper_text' => '',
            'description' => '',
            'tooltip' => '',
        ],
        'country' => [
            'label' => 'Country',
            'placeholder' => '',
            'helper_text' => '',
            'description' => '',
            'tooltip' => '',
        ],
        'capacity' => [
            'label' => 'Capacity',
            'placeholder' => '',
            'helper_text' => 'Maximum number of people.',
            'description' => '',
            'tooltip' => '',
        ],
        'website' => [
            'label' => 'Website',
            'placeholder' => 'https://',
            'helper_text' => '',
            'description' => '',
            'tooltip' => '',
        ],
        'phone' => [
            'label' => 'Phone',
            'placeholder' => '',
            'helper_text' => '',
            'description' => '',
            'tooltip' => '',
        ],
        'latitude' => [
            'label' => 'Latitude',
            'placeholder' => '',
            'helper_text' => 'Optional: used for the map.',
            'description' => '',
            'tooltip' => '',
        ],
        'longitude' => [
            'label' => 'Longitude',
            'placeholder' => '',
            'helper_text' => 'Optional: used for the map.',
            'description' => '',
            'tooltip' => '',
        ],
        'description' => [
            'label' => 'Notes',
            'placeholder' => '',
            'helper_text' => 'How to get there, which floor, parking…',
            'description' => '',
            'tooltip' => '',
        ],
        'events_count' => [
            'label' => 'Events',
            'placeholder' => '',
            'helper_text' => '',
            'description' => '',
            'tooltip' => '',
        ],
    ],
];
