<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Settings',
        'group' => 'Territory Management',
        'icon' => 'heroicon-o-cog-6-tooth',
        'sort' => '99',
    ],
    'fields' => [
        'google_maps_api_key' => [
            'label' => 'Google Maps API Key',
            'helper' => 'API key for Google Maps integration',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'debugbar_enabled' => [
            'label' => 'Debug Bar',
            'helper' => 'Enable/disable the debug bar',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'save' => 'Save Settings',
        'reset' => 'Ripristina Predefiniti',
    ],
    'messages' => [
        'saved' => 'Settings saved successfully',
        'error' => 'Error while saving settings',
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
];
