<?php

declare(strict_types=1);

// UI translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// claude-audit static: split from opening_hours_field.php for maintainability (<500 LOC).
// Canon: Modules/UI/docs/wiki/concepts/claude-audit-static.md
// File: lang/it/opening_hours_field_steps.php
return [
    'steps' => [
        'Afternoon to' => [
            'description' => 'Afternoon to',
            'helper_text' => 'Afternoon to',
            'placeholder' => 'Afternoon to',
            'label' => 'Afternoon to',
        ],
        'Morning from' => [
            'label' => 'Morning from',
            'placeholder' => 'Morning from',
            'helper_text' => 'Morning from',
            'description' => 'Morning from',
        ],
        'Morning to' => [
            'label' => 'Morning to',
            'placeholder' => 'Morning to',
            'helper_text' => 'Morning to',
            'description' => 'Morning to',
        ],
        'Afternoon from' => [
            'label' => 'Afternoon from',
            'placeholder' => 'Afternoon from',
            'helper_text' => 'Afternoon from',
            'description' => 'Afternoon from',
        ],
    ],
];
