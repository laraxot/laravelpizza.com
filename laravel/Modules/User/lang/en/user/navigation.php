<?php

declare(strict_types=1);

// User translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// claude-audit static: split from user.php for maintainability.
// Canon: Modules/User/docs/wiki — domain i18n only.
// File: lang/en/user/navigation.php
return [
    'name' => 'Users',
    'plural' => 'Users',
    'group' => [
        'name' => 'User management',
        'description' => 'Management of users and their permissions',
    ],
    'label' => 'Users',
    'sort' => '26',
    'icon' => 'user-main',
];
