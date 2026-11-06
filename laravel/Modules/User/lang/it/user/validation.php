<?php

declare(strict_types=1);

// User translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// claude-audit static: split from user.php for maintainability.
// Canon: Modules/User/docs/wiki — domain i18n only.
// File: lang/it/user/validation.php
return [
    'required' => 'Il campo :attribute è obbligatorio',
    'email' => 'Il campo :attribute deve essere un indirizzo email valido',
    'unique' => 'Il campo :attribute è già in uso',
    'min' => 'Il campo :attribute deve contenere almeno :min caratteri',
    'max' => 'Il campo :attribute non può superare :max caratteri',
    'confirmed' => 'La conferma del campo :attribute non corrisponde',
    'same' => 'Il campo :attribute deve corrispondere a :other',
    'email_unique' => 'Questa email è già in uso',
    'password_min' => 'La password deve essere di almeno :min caratteri',
    'password_confirmed' => 'Le password non coincidono',
    'current_password' => 'La password attuale non è corretta',
    'password_complexity' => 'La password deve contenere almeno 8 caratteri, una lettera maiuscola, una minuscola, un numero e un carattere speciale',
];
