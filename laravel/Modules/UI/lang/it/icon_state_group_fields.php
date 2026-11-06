<?php

declare(strict_types=1);
// UI translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// claude-audit static: loader for icon_state_group_fields (split <500 LOC).
// Canon: Modules/UI/docs/wiki/concepts/claude-audit-static.md
// File: lang/it/icon_state_group_fields.php

/** @var array<string, mixed> $chunk01 */
$chunk01 = require __DIR__.'/icon_state_group_fields_chunk01.php';
/** @var array<string, mixed> $chunk02 */
$chunk02 = require __DIR__.'/icon_state_group_fields_chunk02.php';

return [
    'fields' => array_merge($chunk01, $chunk02),
];
