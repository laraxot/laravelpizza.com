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
    'created' => 'User created successfully',
    'updated' => 'User updated successfully',
    'deleted' => 'User deleted successfully',
    'blocked' => 'User blocked successfully',
    'unblocked' => 'User unblocked successfully',
    'reset_link_sent' => 'Password reset link sent',
    'email_verified' => 'Email verified successfully',
    'impersonating' => 'You are impersonating the user :name',
    'login_success' => 'Login successful',
    'validation_error' => 'Validation error',
    'login_error' => 'An error occurred during login. Please try again later.',
    'activity' => [
        'log_registered' => 'User registered',
    ],
    'user_not_found' => 'User not found',
    'user_invalid' => 'Invalid user',
];
