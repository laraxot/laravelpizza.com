<?php

declare(strict_types=1);

// UI translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// claude-audit static: split from opening_hours_field.php for maintainability (<500 LOC).
// Canon: Modules/UI/docs/wiki/concepts/claude-audit-static.md
// File: lang/it/opening_hours_field_navigation.php
return [
    'navigation' => [
        'name' => 'Opening Hours Field',
        'plural' => 'Opening Hours Field',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Opening Hours Field',
        'sort' => 1,
        'icon' => 'heroicon-o-rectangle-stack',
    ],
];
