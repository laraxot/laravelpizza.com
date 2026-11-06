<?php

declare(strict_types=1);

// User translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// claude-audit static: split from user.php for maintainability (<500 LOC).
// Canon: Modules/User/docs/wiki/concepts/claude-audit-static.md
// File: lang/it/user_verify_email.php
return [
    'verify_email' => [
        'subject' => 'Verifica Email',
        'greeting' => 'Ciao :name',
        'line1' => 'Clicca sul pulsante qui sotto per verificare il tuo indirizzo email',
        'action' => 'Verifica Email',
        'line2' => 'Se non hai creato un account, non è necessaria alcuna azione',
        'salutation' => 'Cordiali saluti, :app_name',
    ],
];
