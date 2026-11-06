<?php

declare(strict_types=1);

// User translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// claude-audit static: split from user.php for maintainability (<500 LOC).
// Canon: Modules/User/docs/wiki/concepts/claude-audit-static.md
// File: lang/it/user_bulk_actions.php
return [
    'bulk_actions' => [
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
    ],
];
