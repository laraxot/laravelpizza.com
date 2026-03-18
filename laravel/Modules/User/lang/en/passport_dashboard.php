<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Passport / API',
        'plural_label' => 'Passport / API',
        'group' => 'System',
        'icon' => 'heroicon-o-key',
        'sort' => 95,
    ],
    'label' => 'Passport / API',
    'plural_label' => 'Passport / API',
    'fields' => [
        'client_id' => [
            'label' => 'Client ID',
            'placeholder' => 'Enter client ID',
            'help' => 'OAuth client identifier',
        ],
        'client_secret' => [
            'label' => 'Client Secret',
            'placeholder' => 'Enter client secret',
            'help' => 'Secret for OAuth authentication',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Create Client',
            'tooltip' => 'Create a new OAuth client',
        ],
        'revoke' => [
            'label' => 'Revoke',
            'tooltip' => 'Revoke access',
        ],
        'install' => [
            'label' => 'Install Passport',
            'modal_description' => 'This command will install Passport and create the necessary encryption keys.',
            'force_label' => 'Force overwrite keys',
            'force_help' => 'Overwrites existing keys if present.',
        ],
        'keys' => [
            'label' => 'Generate keys',
            'force_label' => 'Force overwrite',
            'force_help' => 'Overwrites existing keys (required if keys already exist).',
        ],
        'purge' => [
            'label' => 'Purge tokens',
            'revoked_label' => 'Remove revoked tokens',
            'revoked_help' => 'Deletes revoked tokens and codes.',
            'expired_label' => 'Remove expired tokens',
            'expired_help' => 'Deletes tokens expired for more than N hours.',
            'hours_label' => 'Retention hours',
            'hours_help' => 'Tokens expired for more than N hours will be deleted (default 168 = 7 days).',
        ],
        'purge_tokens' => [
            'label' => 'Purge Tokens',
            'modal_description' => 'Revoked and/or expired tokens and codes will be removed according to selected options.',
        ],
        'hash' => [
            'label' => 'Hash secrets',
            'force_label' => 'Force without confirmation',
            'force_help' => 'Runs without confirmation prompt.',
        ],
        'hash_secrets' => [
            'label' => 'Hash Secrets',
            'modal_description' => 'Apply hashing to all existing client secrets. Irreversible operation.',
        ],
        'generate_keys' => [
            'label' => 'Generate Keys',
        ],
    ],
    'status' => [
        'public_key' => 'Public Key',
        'private_key' => 'Private Key',
        'present' => 'Present',
        'missing' => 'Missing',
    ],
    'messages' => [
        'client_created' => 'Client created successfully',
        'client_revoked' => 'Client revoked successfully',
        'command_started' => 'Command started...',
        'command_completed' => 'Command completed successfully',
        'command_failed' => 'Command execution failed',
        'command_error' => 'Error during command execution',
    ],
];
