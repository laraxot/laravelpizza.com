<?php

declare(strict_types=1);

// User translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// claude-audit static: split from user.php for maintainability (<500 LOC).
// Canon: Modules/User/docs/wiki/concepts/claude-audit-static.md
// File: lang/it/user_reset_password.php
return [
    'reset_password' => [
        'password_reset_subject' => 'Reset Password',
        'password_cause_of_email' => 'Hai ricevuto questa email perché abbiamo ricevuto una richiesta di reset password per il tuo account',
        'reset_password' => 'Reset Password',
        'password_if_not_requested' => 'Se non hai richiesto il reset della password, non è necessaria alcuna azione',
        'thank_you_for_using_app' => 'Grazie per utilizzare la nostra applicazione',
        'regards' => 'Cordiali saluti',
    ],
];
