<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Reset Password',
        'plural' => 'Reset Password',
        'label' => 'Reset Password',
        'group' => ['name' => 'Sicurezza', 'description' => 'Gestione dei reset password e recupero credenziali'],
        'sort' => 4,
        'icon' => 'heroicon-o-key',
    ],
    'label' => 'Password Reset',
    'plural_label' => 'Password Reset (Plurale)',
    'fields' => [
        'edit' => ['label' => 'Modifica Password Reset'],
        'delete' => ['label' => 'Elimina Password Reset'],
    ],
];
