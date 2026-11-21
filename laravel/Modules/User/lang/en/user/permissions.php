<?php

declare(strict_types=1);

// User translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// claude-audit static: split from user.php for maintainability.
// Canon: Modules/User/docs/wiki — domain i18n only.
// File: lang/en/user/permissions.php
return [
    'view_users' => 'View users',
    'create_users' => 'Create users',
    'edit_users' => 'Edit users',
    'delete_users' => 'Delete users',
    'impersonate_users' => 'Impersonate users',
    'manage_roles' => 'Manage roles',
];
