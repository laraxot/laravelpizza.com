<?php

declare(strict_types=1);

return [
    'actions' => [
        'select' => [
            'label' => 'Select',
            'description' => 'Choose this studio',
        ],
    ],
    'empty' => [
        'title' => 'No studio found',
        'description' => 'There are no studios available for the selected area.',
    ],
    'fields' => [
        'distance' => [
            'label' => 'Distanza',
            'helper_text' => 'Approximate distance from your location',
            'tooltip' => '',
            'description' => '',
        ],
        'phone' => [
            'label' => 'Phone',
            'helper_text' => 'Studio phone number',
            'tooltip' => '',
            'description' => '',
        ],
        'specializations' => [
            'label' => 'Specializzazioni',
            'helper_text' => 'Servizi offerti dallo studio',
            'tooltip' => '',
            'description' => '',
        ],
    ],
    'accessibility' => [
        'studio_card' => 'Studio card, click to select',
        'selected_studio' => 'Selected studio',
        'select_studio' => 'Press space or enter to select this studio',
    ],
    'navigation' => [
        'label' => 'Missing Navigation Label',
        'plural_label' => 'Missing Navigation Plural Label',
        'group' => 'Missing Group',
        'icon' => 'heroicon-o-puzzle-piece',
        'sort' => 100,
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
    'card' => [
        'address_unavailable' => [
            'label' => 'Address not available',
        ],
        'visit_website' => [
            'label' => 'Visit website',
        ],
        'services_offered' => [
            'label' => 'Services offered',
        ],
        'more_services' => [
            'label' => '+:count more',
        ],
        'today_hours' => [
            'label' => 'Today: :open - :close',
        ],
        'today_closed' => [
            'label' => 'Today: Closed',
        ],
        'actions' => [
            'book' => 'Book',
            'details' => 'Details',
            'call' => 'Call',
        ],
    ],
    'list' => [
        'services_count' => [
            'label' => ':count services',
        ],
        'empty' => [
            'title' => 'No studio found',
            'description' => 'There are no studios available in the selected area.',
        ],
        'selected' => [
            'label' => 'Selected studio: :name',
        ],
    ],
    'sections' => [
        'buttons' => [
            'title' => 'The dental studios closest to you',
        ],
    ],
    'buttons' => [
        'empty' => [
            'message' => 'No studio found matching the selected search criteria.',
        ],
    ],
];
