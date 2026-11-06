<?php

declare(strict_types=1);

return [
    'navigation' => ['group' => 'Impostazioni provider socialite'],
    'sections' => [
        'Google OAuth' => ['label' => 'Google OAuth', 'heading' => 'Google OAuth'],
        'GitHub OAuth' => ['label' => 'GitHub OAuth', 'heading' => 'GitHub OAuth'],
        'Microsoft OAuth' => ['label' => 'Microsoft OAuth', 'heading' => 'Microsoft OAuth'],
    ],
    'fields' => [
        'google' => [
            'enabled' => ['label' => 'google.enabled', 'placeholder' => 'google.enabled', 'helper_text' => 'google.enabled', 'description' => 'google.enabled'],
            'client_id' => ['label' => 'google.client_id', 'placeholder' => 'google.client_id', 'helper_text' => 'google.client_id', 'description' => 'google.client_id'],
            'client_secret' => ['label' => 'google.client_secret', 'placeholder' => 'google.client_secret', 'helper_text' => 'google.client_secret', 'description' => 'google.client_secret'],
            'scopes' => ['label' => 'google.scopes', 'placeholder' => 'google.scopes', 'helper_text' => 'google.scopes', 'description' => 'google.scopes'],
            'redirect' => ['label' => 'google.redirect', 'placeholder' => 'google.redirect', 'helper_text' => 'google.redirect', 'description' => 'google.redirect'],
        ],
        'github' => [
            'enabled' => ['label' => 'github.enabled', 'placeholder' => 'github.enabled', 'helper_text' => 'github.enabled', 'description' => 'github.enabled'],
            'client_id' => ['label' => 'github.client_id', 'placeholder' => 'github.client_id', 'helper_text' => 'github.client_id', 'description' => 'github.client_id'],
            'client_secret' => ['label' => 'github.client_secret', 'placeholder' => 'github.client_secret', 'helper_text' => 'github.client_secret', 'description' => 'github.client_secret'],
            'scopes' => ['label' => 'github.scopes', 'placeholder' => 'github.scopes', 'helper_text' => 'github.scopes', 'description' => 'github.scopes'],
            'redirect' => ['label' => 'github.redirect', 'placeholder' => 'github.redirect', 'helper_text' => 'github.redirect', 'description' => 'github.redirect'],
        ],
        'microsoft' => [
            'enabled' => ['label' => 'microsoft.enabled', 'placeholder' => 'microsoft.enabled', 'helper_text' => 'microsoft.enabled', 'description' => 'microsoft.enabled'],
            'client_id' => ['label' => 'microsoft.client_id', 'placeholder' => 'microsoft.client_id', 'helper_text' => 'microsoft.client_id', 'description' => 'microsoft.client_id'],
            'client_secret' => ['label' => 'microsoft.client_secret', 'placeholder' => 'microsoft.client_secret', 'helper_text' => 'microsoft.client_secret', 'description' => 'microsoft.client_secret'],
            'scopes' => ['label' => 'microsoft.scopes', 'placeholder' => 'microsoft.scopes', 'helper_text' => 'microsoft.scopes', 'description' => 'microsoft.scopes'],
            'redirect' => ['label' => 'microsoft.redirect', 'placeholder' => 'microsoft.redirect', 'helper_text' => 'microsoft.redirect', 'description' => 'microsoft.redirect'],
        ],
    ],
];
