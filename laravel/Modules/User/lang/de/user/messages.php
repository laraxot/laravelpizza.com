<?php

declare(strict_types=1);

// User translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// claude-audit static: split from user.php for maintainability.
// Canon: Modules/User/docs/wiki — domain i18n only.
// File: lang/de/user/messages.php
return [
    'created' => 'Utente creato con successo',
    'updated' => 'Utente aggiornato con successo',
    'deleted' => 'Utente eliminato con successo',
    'blocked' => 'Utente bloccato con successo',
    'unblocked' => 'Utente sbloccato con successo',
    'reset_link_sent' => 'Link per il reset della password inviato',
    'email_verified' => 'Email verificata con successo',
    'impersonating' => 'Stai impersonando l\'utente :name',
    'credentials_incorrect' => 'Die angegebenen Anmeldedaten sind nicht korrekt',
    'login_success' => 'Anmeldung erfolgreich',
    'validation_error' => 'Validierungsfehler',
    'login_error' => 'Bei der Anmeldung ist ein Fehler aufgetreten. Versuchen Sie es später erneut',
    'activity' => [
        'log_registered' => 'Benutzer registriert',
    ],
    'user_not_found' => 'Benutzer nicht gefunden',
    'user_invalid' => 'Ungültiger Benutzer',
];
