<?php

declare(strict_types=1);

// "Connect an AI assistant" page (Http/Livewire/AssistantTokens, livewire/assistant-tokens.blade.php).
return [
    'intro' => 'With a personal token, Claude, Cursor and other MCP-compatible assistants can search meetups and register you on your behalf, with the same rules as the site.',
    'server' => [
        'title' => 'Server address',
        'help' => 'In your assistant add an HTTP MCP server with this address and the token as an Authorization: Bearer header.',
    ],
    'create' => [
        'title' => 'New token',
        'description' => 'Name the token after the assistant or the computer where you use it: that way you know what to revoke.',
        'submit' => 'Create token',
    ],
    'fields' => [
        'name' => 'Token name',
    ],
    'placeholders' => [
        'name' => 'E.g. Claude on my laptop',
    ],
    'created' => [
        'title' => 'Token created: copy it now',
        'warning' => 'For security we won\'t show it again. If you lose it, revoke it and create another one.',
        'label' => 'Token for :name',
        'copy' => 'Copy token',
        'copied' => 'Copied',
        'config' => 'Example configuration',
        'done' => 'Done, I copied it',
    ],
    'list' => [
        'title' => 'Active tokens',
        'empty' => 'You have no tokens yet: no assistant can use the site on your behalf.',
        'created_at' => 'Created on :date',
        'expires_at' => 'expires on :date',
        'revoke' => 'Revoke',
        'revoke_confirm' => 'Revoke this token? The assistant using it stops working immediately.',
        'revoked' => 'Token revoked.',
    ],
    'safety' => 'Treat the token like a password: whoever has it can register you and cancel your registrations. The assistant always asks for confirmation first.',
    'back' => 'Back to Edit profile',
    'link' => [
        'title' => 'AI assistants',
        'description' => 'Connect Claude, Cursor or another assistant to your account to search meetups and register.',
        'action' => 'Connect an AI assistant',
    ],
];
