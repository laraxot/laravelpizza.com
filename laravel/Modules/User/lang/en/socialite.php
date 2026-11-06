<?php

declare(strict_types=1);

return [
    'actions' => [
        'save' => 'Save',
    ],
    'help' => [
        'title' => 'Setup guide',
        'description' => 'Configure the providers\' OAuth credentials to let users sign in with their social accounts.',
        'google_title' => 'Google OAuth',
        'google_step1' => 'Go to <a href=":url" target="_blank" rel="noopener" class="underline">Google Cloud Console</a> and create a project (or select an existing one).',
        'google_step2' => 'Enable the required APIs and configure the OAuth consent screen.',
        'google_step3' => 'Create "OAuth client ID" credentials of type web application.',
        'google_step4' => 'Copy the client ID and client secret and paste them into the form above.',
        'redirect_url_note' => 'Redirect URL',
        'redirect_url_description' => 'Set the callback URL shown in the form as the authorized redirect URI.',
    ],
    'security' => [
        'title' => 'Security notice',
        'description' => 'Credentials are stored securely. Never share them or commit them to public repositories.',
    ],
];
