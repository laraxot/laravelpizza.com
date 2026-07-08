<?php

declare(strict_types=1);

/**
 * Service Providers Configuration
 * This file defines Socialite OAuth2 credentials for authentication
 * All credentials must be managed through Filament admin (SocialProviderResource)
 * No environment variables are required for production security.
 */

return [
    'google' => ['client_id' => '', 'client_secret' => '', 'redirect' => 'your-google-redirect-uri.com/auth/callback'],
    'microsoft' => ['client_id' => '', 'client_secret' => '', 'redirect' => 'your-microsoft-redirect-uri.com/auth/callback'],
    'github' => ['client_id' => '', 'client_secret' => '', 'redirect' => 'your-github-redirect-uri.com/auth/callback'],
];
