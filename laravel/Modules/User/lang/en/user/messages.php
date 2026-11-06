<?php

declare(strict_types=1);

// User translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// claude-audit static: split from user.php for maintainability.
// Canon: Modules/User/docs/wiki — domain i18n only.
// File: lang/en/user/messages.php
return [
    'no_records' => 'No users found',
    'loading' => 'Loading users...',
    'search' => 'Search users...',
    'credentials_incorrect' => 'The provided credentials are incorrect.',
    'created' => 'Utente creato con successo',
    'updated' => 'Utente aggiornato con successo',
    'deleted' => 'Utente eliminato con successo',
    'blocked' => 'Utente bloccato con successo',
    'unblocked' => 'Utente sbloccato con successo',
    'reset_link_sent' => 'Link per il reset della password inviato',
    'email_verified' => 'Email verificata con successo',
    'impersonating' => 'Stai impersonando l\'utente :name',
    'login_success' => 'Login successful',
    'validation_error' => 'Validation error',
    'login_error' => 'An error occurred during login. Please try again later.',
    'activity' => [
        'log_registered' => 'User registered',
    ],
    'user_not_found' => 'User not found',
    'user_invalid' => 'Invalid user',
];
