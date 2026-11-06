<?php

declare(strict_types=1);

// User translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// claude-audit static: split from user.php for maintainability (<500 LOC).
// Canon: Modules/User/docs/wiki/concepts/claude-audit-static.md
// File: lang/it/user_messages.php
return [
    'messages' => [
        'created' => 'Utente creato con successo',
        'updated' => 'Utente aggiornato con successo',
        'deleted' => 'Utente eliminato con successo',
        'blocked' => 'Utente bloccato con successo',
        'unblocked' => 'Utente sbloccato con successo',
        'activated' => 'Utente attivato con successo',
        'deactivated' => 'Utente disattivato con successo',
        'reset_link_sent' => 'Link per il reset della password inviato',
        'email_verified' => 'Email verificata con successo',
        'impersonating' => 'Stai impersonando l\'utente :name',
        'logout_success' => 'Logout effettuato con successo',
        'logout_error' => 'Errore durante il logout',
        'password_changed' => 'Password modificata con successo',
        'password_expired' => 'La password è scaduta',
        'user_not_found' => 'Utente non trovato',
        'password_fields_required' => 'Tutti i campi password sono obbligatori',
        'password_current_incorrect' => 'La password attuale non è corretta',
        'credentials_incorrect' => 'Le credenziali fornite non sono corrette...',
        'login_error' => 'Si è verificato un errore durante il login. Riprova più tardi',
        'logout_error_generic' => 'Errore durante il logout. Riprova.',
        'team_switched' => 'Team cambiato con successo',
        'registration_success' => 'Registrazione completata con successo',
        'registration_error' => 'Si è verificato un errore durante la registrazione',
        'otp_sent' => 'Codice OTP inviato con successo',
        'otp_expired' => 'Il codice OTP è scaduto',
        'password_reset_success' => 'Password reimpostata con successo',
        'password_reset_error' => 'Errore durante il reset della password',
        'email_already_taken' => 'Questa email è già in uso',
        'login_success' => 'Accesso effettuato con successo',
        'validation_error' => 'Errore di validazione',
    ],
];
