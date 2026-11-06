<?php

declare(strict_types=1);

// User translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// claude-audit static: split from user.php for maintainability.
// Canon: Modules/User/docs/wiki — domain i18n only.
// File: lang/it/user/otp.php
return [
    'mail' => [
        'subject' => 'Codice OTP per l\'accesso',
        'greeting' => 'Ciao :name',
        'line1' => 'Il tuo codice OTP è: :code',
        'line2' => 'Questo codice scade tra :minutes minuti',
        'line3' => 'Non condividere questo codice con nessuno',
        'salutation' => 'Cordiali saluti, :app_name',
    ],
    'notifications' => [
        'otp_expired' => [
            'body' => 'Il codice OTP è scaduto',
        ],
    ],
    'actions' => [
        'send_otp_success' => 'Codice OTP inviato con successo',
    ],
];
