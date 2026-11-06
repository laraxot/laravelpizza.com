<?php

declare(strict_types=1);

// UI translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// claude-audit static: split from opening_hours_field.php for maintainability (<500 LOC).
// Canon: Modules/UI/docs/wiki/concepts/claude-audit-static.md
// File: lang/it/opening_hours_field_actions.php
return [
    'actions' => [
        'copy_schedule' => [
            'label' => 'Copia Orari',
            'success' => 'Orari copiati con successo',
            'error' => 'Errore durante la copia degli orari',
        ],
        'clear_schedule' => [
            'label' => 'Cancella Orari',
            'success' => 'Orari cancellati con successo',
            'confirmation' => 'Sei sicuro di voler cancellare tutti gli orari?',
        ],
    ],
];
