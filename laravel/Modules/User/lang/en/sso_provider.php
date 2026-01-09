<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'SSO Provider',
        'group' => 'Authentication',
        'icon' => 'heroicon-o-shield-check',
        'sort' => 41,
    ],
    'label' => 'SSO Provider',
    'plural_label' => 'SSO Providers',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'name' => [
            'label' => 'Name',
        ],
        'provider' => [
            'label' => 'Provider',
        ],
        'client_id' => [
            'label' => 'Client ID',
        ],
        'client_secret' => [
            'label' => 'Client Secret',
        ],
        'redirect' => [
            'label' => 'Redirect',
        ],
        'active' => [
            'label' => 'Active',
        ],
        'created_at' => [
            'label' => 'Created At',
        ],
        'updated_at' => [
            'label' => 'Updated At',
        ],
    ],
    'actions' => [
        'activate' => [
            'label' => 'Activate',
        ],
        'deactivate' => [
            'label' => 'Deactivate',
        ],
        'test_connection' => [
            'label' => 'Test Connection',
        ],
    ],
];