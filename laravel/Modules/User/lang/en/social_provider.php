<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Social Providers',
        'plural_label' => 'Social Providers',
        'group' => 'User Management',
        'icon' => 'heroicon-o-share',
        'sort' => 93,
    ],
    'label' => 'Social Provider',
    'plural_label' => 'Social Providers',
    'fields' => [
        'name' => [
            'label' => 'Name',
            'placeholder' => 'Enter provider name',
            'helper_text' => 'Identifying name for the social provider',
        ],
        'client_id' => [
            'label' => 'Client ID',
            'placeholder' => 'Enter client ID',
        ],
        'client_secret' => [
            'label' => 'Client Secret',
            'placeholder' => 'Enter client secret',
        ],
        'redirect' => [
            'label' => 'Redirect URL',
            'placeholder' => 'Enter redirect URL',
        ],
        'scopes' => [
            'label' => 'Scopes',
            'helper_text' => 'OAuth scopes',
        ],
        'parameters' => [
            'label' => 'Parameters',
            'helper_text' => 'Additional URL parameters',
        ],
        'stateless' => [
            'label' => 'Stateless',
        ],
        'active' => [
            'label' => 'Active',
        ],
        'socialite' => [
            'label' => 'Socialite',
        ],
        'svg' => [
            'label' => 'Icon SVG',
            'placeholder' => '<svg>...</svg>',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Create',
        ],
    ],
    'messages' => [
        'created' => 'Provider created successfully',
        'updated' => 'Provider updated successfully',
        'deleted' => 'Provider deleted successfully',
    ],
];
