<?php

declare(strict_types=1);

// User translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// claude-audit static: split from user.php for maintainability.
// Canon: Modules/User/docs/wiki — domain i18n only.
// File: lang/en/user/validation.php
return [
    'email_unique' => 'This email is already in use',
    'password_min' => 'The password must be at least :min characters',
    'password_confirmed' => 'The passwords do not match',
    'current_password' => 'The current password is incorrect',
];
