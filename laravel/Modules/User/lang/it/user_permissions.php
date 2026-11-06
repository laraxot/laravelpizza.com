<?php

declare(strict_types=1);

// User translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// claude-audit static: split from user.php for maintainability (<500 LOC).
// Canon: Modules/User/docs/wiki/concepts/claude-audit-static.md
// File: lang/it/user_permissions.php
return [
    'permissions' => [
        'view_users' => 'Visualizza utenti',
        'create_users' => 'Crea utenti',
        'edit_users' => 'Modifica utenti',
        'delete_users' => 'Elimina utenti',
        'impersonate_users' => 'Impersona utenti',
        'manage_roles' => 'Gestisci ruoli',
        'manage_permissions' => 'Gestisci permessi',
        'view_roles' => 'Visualizza ruoli',
        'create_roles' => 'Crea ruoli',
        'edit_roles' => 'Modifica ruoli',
        'delete_roles' => 'Elimina ruoli',
    ],
];
