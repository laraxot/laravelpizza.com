<?php

declare(strict_types=1);

return [
    'fields' => [
        'name' => 'Name',
        'name.placeholder' => 'Enter provider name',
        'name.helper_text' => 'The name of the social provider (e.g. Facebook, Google)',
        'scopes' => 'Scopes',
        'scopes.placeholder' => 'Enter access scopes',
        'scopes.helper_text' => 'The access scopes required by the provider',
        'parameters' => 'Parameters',
        'parameters.placeholder' => 'Enter additional parameters',
        'parameters.helper_text' => 'Additional parameters for configuration',
        'stateless' => 'Stateless',
        'stateless.helper_text' => 'Whether the provider maintains no session state',
        'active' => 'Active',
        'active.helper_text' => 'Whether the provider is currently active',
        'socialite' => 'Socialite',
        'socialite.helper_text' => 'Whether the provider uses Laravel Socialite',
        'svg' => 'SVG',
        'svg.placeholder' => 'Enter the SVG icon code',
        'svg.helper_text' => 'The SVG icon for the social provider',
    ],
];
