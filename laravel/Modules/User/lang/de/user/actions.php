<?php

declare(strict_types=1);

// User translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// claude-audit static: split from user.php for maintainability.
// Canon: Modules/User/docs/wiki — domain i18n only.
// File: lang/de/user/actions.php
return [
    'create' => 'Crea Utente',
    'edit' => 'Modifica Utente',
    'delete' => 'Elimina Utente',
    'impersonate' => 'Impersona Utente',
    'stop_impersonating' => 'Termina Impersonificazione',
    'block' => 'Blocca',
    'unblock' => 'Sblocca',
    'send_reset_link' => 'Invia Link Reset Password',
    'verify_email' => 'Verifica Email',
];
