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
        'client_name' => [
            'label' => 'Client name',
        ],
    ],
    'actions' => [
        'new_credentials' => [
            'label' => 'New credentials',
        ],
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
        ],
        'generate_keys' => [
            'label' => 'Generate Keys',
        ],
        'purge_tokens' => [
            'label' => 'Purge Tokens',
            'modal_description' => 'Delete all expired or revoked tokens.',
        ],
        'hash_secrets' => [
            'label' => 'Hash Secrets',
            'modal_description' => 'Apply hashing to all existing client secrets.',
        ],
    ],
    'status' => [
        'public_key' => 'Public Key',
        'private_key' => 'Private Key',
        'present' => 'Present',
        'missing' => 'Missing',
        'completed' => [
            'message' => 'Completed',
        ],
        'failed' => [
            'message' => 'Failed',
        ],
        'running' => [
            'message' => 'Running...',
        ],
    ],
    'messages' => [
        'client_created' => 'Client created successfully',
        'client_revoked' => 'Client revoked successfully',
        'command_started' => 'Command started...',
        'command_completed' => 'Command completed successfully',
        'command_failed' => 'Command execution failed',
        'command_error' => 'Error during command execution',
        'credentials_created' => 'Credentials created successfully',
    ],
    'view' => [
        'running_notice' => [
            'message' => 'The command is running. Please do not close this window.',
        ],
        'actions_disabled' => [
            'description' => 'Other actions are disabled until the command completes.',
        ],
        'running_command' => [
            'message' => 'Running command: php artisan',
        ],
        'waiting_output' => [
            'message' => 'Waiting for output...',
        ],
        'select_command' => [
            'label' => 'Select a command from the header to begin.',
        ],
        'scroll' => [
            'helper_text' => 'Use mouse wheel to scroll output.',
        ],
    ],
];
