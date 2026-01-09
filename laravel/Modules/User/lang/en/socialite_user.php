<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Socialite User',
        'group' => 'Authentication',
        'icon' => 'heroicon-o-user-group',
        'sort' => 40,
    ],
    'label' => 'Socialite User',
    'plural_label' => 'Socialite Users',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'user_id' => [
            'label' => 'User',
        ],
        'provider' => [
            'label' => 'Provider',
        ],
        'provider_id' => [
            'label' => 'Provider ID',
        ],
        'name' => [
            'label' => 'Name',
        ],
        'email' => [
            'label' => 'Email',
        ],
        'avatar' => [
            'label' => 'Avatar',
        ],
        'token' => [
            'label' => 'Token',
        ],
        'refresh_token' => [
            'label' => 'Refresh Token',
        ],
        'expires_at' => [
            'label' => 'Expires At',
        ],
    ],
    'actions' => [
        'link_provider' => [
            'label' => 'Link Provider',
        ],
        'unlink_provider' => [
            'label' => 'Unlink Provider',
        ],
    ],
];
