<?php

declare(strict_types=1);

// User translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// claude-audit static: split from user.php for maintainability (<500 LOC).
// Canon: Modules/User/docs/wiki/concepts/claude-audit-static.md
// File: lang/it/user_notifications.php
return [
    'notifications' => [
        'created' => 'Utente creato con successo',
        'updated' => 'Utente aggiornato con successo',
        'deleted' => 'Utente eliminato con successo',
        'password_changed' => 'Password modificata con successo',
        'email_verified' => 'Email verificata con successo',
        'otp_sent' => 'Codice OTP inviato',
        'error' => 'Si è verificato un errore',
    ],
];
