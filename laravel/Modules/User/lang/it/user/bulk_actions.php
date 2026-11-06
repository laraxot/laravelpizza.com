<?php

declare(strict_types=1);

// User translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// claude-audit static: split from user.php for maintainability.
// Canon: Modules/User/docs/wiki — domain i18n only.
// File: lang/it/user/bulk_actions.php
return [
    'activate_selected' => [
        'label' => 'Attiva Selezionati',
        'icon' => 'heroicon-o-check',
    ],
    'deactivate_selected' => [
        'label' => 'Disattiva Selezionati',
        'icon' => 'heroicon-o-x-circle',
    ],
    'delete_selected' => [
        'label' => 'Elimina Selezionati',
        'icon' => 'heroicon-o-trash',
    ],
    'block_selected' => [
        'label' => 'Blocca Selezionati',
        'icon' => 'heroicon-o-lock-closed',
    ],
    'unblock_selected' => [
        'label' => 'Sblocca Selezionati',
        'icon' => 'heroicon-o-lock-open',
    ],
];
