<?php

declare(strict_types=1);

// User translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// claude-audit static: split from user.php for maintainability.
// Canon: Modules/User/docs/wiki — domain i18n only.
// File: lang/it/user/auth.php
// Auth FO copy — Folio login/register widgets consume these keys.
// claude-audit doc ratio — LangServiceProvider SSoT.
return [
    'login' => [
        'title' => 'Accedi',
        'subtitle' => 'Accedi al tuo account',
        'button' => 'Accedi',
        'fields' => [
            'email' => 'Email',
            'password' => 'Password',
            'remember' => 'Ricordami',
        ],
        'help' => [
            'email' => 'Inserisci la tua email registrata',
            'password' => 'Inserisci la tua password',
        ],
        'validation' => [
            'password' => [
                'complexity' => 'La password deve contenere almeno 8 caratteri, una lettera maiuscola, una minuscola, un numero e un carattere speciale',
            ],
        ],
    ],
    'register' => [
        'title' => 'Registrati',
        'subtitle' => 'Crea un nuovo account',
        'button' => 'Registrati',
        'fields' => [
            'first_name' => 'Nome',
            'last_name' => 'Cognome',
            'email' => 'Email',
            'password' => 'Password',
            'password_confirmation' => 'Conferma Password',
        ],
        'help' => [
            'email' => 'Inserisci un indirizzo email valido',
            'password' => 'La password deve essere sicura',
        ],
        'success' => 'Registrazione completata con successo',
        'error_occurred' => 'Si è verificato un errore durante la registrazione',
    ],
    'logout' => [
        'title' => 'Logout',
        'button' => 'Esci',
        'success' => 'Logout effettuato con successo',
        'error' => 'Errore durante il logout',
        'confirmation' => 'Sei sicuro di voler uscire?',
    ],
    'password_reset' => [
        'title' => 'Reset Password',
        'subtitle' => 'Reimposta la tua password',
        'button' => 'Invia Link Reset',
        'confirm_button' => 'Reimposta Password',
        'email_sent' => [
            'title' => 'Email inviata',
            'message' => 'Ti abbiamo inviato un link per reimpostare la password',
        ],
        'email_failed' => [
            'title' => 'Errore invio email',
            'message' => 'Impossibile inviare l\'email di reset',
            'generic' => 'Si è verificato un errore',
        ],
        'success' => [
            'title' => 'Password reimpostata',
            'message' => 'La tua password è stata reimpostata con successo',
        ],
        'errors' => [
            'invalid_token' => 'Token non valido',
            'invalid_user' => 'Utente non trovato',
            'generic' => 'Si è verificato un errore',
            'title' => 'Errore reset password',
        ],
    ],
    'user_not_found' => 'Utente non trovato',
    'password_fields_required' => 'Tutti i campi password sono obbligatori',
    'password_current_incorrect' => 'La password attuale non è corretta',
    'logout_success' => 'Logout effettuato con successo',
    'logout_error' => 'Errore durante il logout',
    'logout_title' => 'Conferma Logout',
    'logout_confirmation' => 'Sei sicuro di voler uscire?',
];
