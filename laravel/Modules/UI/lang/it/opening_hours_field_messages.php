<?php

declare(strict_types=1);

// UI translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// claude-audit static: split from opening_hours_field.php for maintainability (<500 LOC).
// Canon: Modules/UI/docs/wiki/concepts/claude-audit-static.md
// File: lang/it/opening_hours_field_messages.php
return [
    'messages' => [
        'no_availability' => 'Nessuna disponibilità configurata',
        'schedule_saved' => 'Orari salvati correttamente',
        'invalid_time_range' => 'Orario non valido: l\'ora di fine deve essere successiva all\'ora di inizio',
    ],
];
