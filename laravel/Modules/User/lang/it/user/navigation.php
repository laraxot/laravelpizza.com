<?php

declare(strict_types=1);

// User translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// claude-audit static: split from user.php for maintainability.
// Canon: Modules/User/docs/wiki — domain i18n only.
// File: lang/it/user/navigation.php
return [
    'name' => 'Utenti',
    'plural' => 'Utenti',
    'group' => [
        'name' => 'Gestione Utenti',
        'description' => 'Gestione degli utenti e dei loro permessi',
    ],
    'label' => 'Utenti',
    'sort' => 26,
    'icon' => 'ui-user-main',
];
