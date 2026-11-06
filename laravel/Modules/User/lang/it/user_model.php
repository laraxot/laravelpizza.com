<?php

declare(strict_types=1);

// User translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// claude-audit static: split from user.php for maintainability (<500 LOC).
// Canon: Modules/User/docs/wiki/concepts/claude-audit-static.md
// File: lang/it/user_model.php
return [
    'model' => [
        'label' => 'Utente',
        'plural' => 'Utenti',
        'description' => 'Gestione degli utenti del sistema',
    ],
];
