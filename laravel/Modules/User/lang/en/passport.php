<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'OAuth Passport',
        'group' => 'Authentication',
        'icon' => 'heroicon-o-key',
        'sort' => 17,
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
    'fields' => [
    ],
    'actions' => [
    ],
    'stats' => [
        'clients_total' => 'Total clients',
        'clients_description' => 'Registered OAuth clients',
        'tokens_total' => 'Total tokens',
        'tokens_description' => 'Issued access tokens',
        'tokens_valid' => 'Valid tokens',
        'tokens_valid_description' => 'Active and non-expired tokens',
        'tokens_revoked' => 'Revoked tokens',
        'tokens_revoked_description' => 'Revoked tokens',
        'refresh_tokens_total' => 'Refresh tokens',
        'refresh_tokens_description' => 'Refresh tokens',
    ],
];
