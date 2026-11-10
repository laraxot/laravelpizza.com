<?php

declare(strict_types=1);

// Etichette del form (SponsorResource/Schemas/SponsorForm, usato anche dal form evento).
return [
    'fields' => [
        'name' => [
            'label' => 'Name',
            'placeholder' => '',
            'helper_text' => '',
            'description' => '',
            'tooltip' => '',
        ],
        'level' => [
            'label' => 'Level',
            'placeholder' => '',
            'helper_text' => '',
            'description' => '',
            'tooltip' => '',
            'options' => [
                'platinum' => 'Platinum',
                'gold' => 'Gold',
                'silver' => 'Silver',
                'bronze' => 'Bronze',
                'community' => 'Community',
            ],
        ],
        'website' => [
            'label' => 'Website',
            'placeholder' => 'https://',
            'helper_text' => '',
            'description' => '',
            'tooltip' => '',
        ],
        'logo' => [
            'label' => 'Logo (URL)',
            'placeholder' => 'https://',
            'helper_text' => 'Address of the logo image.',
            'description' => '',
            'tooltip' => '',
        ],
        'contact_name' => [
            'label' => 'Contact person',
            'placeholder' => '',
            'helper_text' => '',
            'description' => '',
            'tooltip' => '',
        ],
        'contact_email' => [
            'label' => 'Contact email',
            'placeholder' => '',
            'helper_text' => '',
            'description' => '',
            'tooltip' => '',
        ],
        'order' => [
            'label' => 'Order',
            'placeholder' => '',
            'helper_text' => 'Lower numbers are shown first.',
            'description' => '',
            'tooltip' => '',
        ],
        'description' => [
            'label' => 'Description',
            'placeholder' => '',
            'helper_text' => '',
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
