<?php

declare(strict_types=1);

// UI translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// claude-audit static: split from icon_state_group.php for maintainability (<500 LOC).
// Canon: Modules/UI/docs/wiki/concepts/claude-audit-static.md
// File: lang/it/icon_state_group_navigation.php
return [
    'navigation' => [
        'name' => 'Icon State Group',
        'plural' => 'Icon State Group',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Icon State Group',
        'sort' => 1,
        'icon' => 'heroicon-o-rectangle-stack',
    ],
];
