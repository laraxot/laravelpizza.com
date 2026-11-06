<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Tables\Columns;

use Modules\Xot\Filament\Tables\Columns\XotBaseTextColumn;

/**
 * Colonna data/ora standard del progetto: `dateTime()`, `sortable()`,
 * placeholder `—` per i valori nulli.
 *
 * Stesso trio (`dateTime()->sortable()->placeholder('—')`) ripetuto
 * identico per `created_at`/`updated_at` in 30+ classi `Tables/*.php`.
 * `toggleable()` NON e' incluso qui: `created_at` e `updated_at` differiscono
 * su questo punto nel codice esistente (`updated_at` di solito nascosta di
 * default, `created_at` no) — resta una scelta del chiamante, componibile
 * come qualunque altro metodo Filament:
 *
 * ```php
 * 'created_at' => TimestampColumn::make('created_at'),
 * 'updated_at' => TimestampColumn::make('updated_at')->toggleable(isToggledHiddenByDefault: true),
 * ```
 *
 * @see Modules/UI/docs/form-column-parity.md
 */
/*
 * GateGuard: callers TimestampColumnTest + 30+ Tables created_at/updated_at;
 * unique datetime column helper; reads datetime scalars; user: "migliora qualità codice , fa tutto con bmad + second brain + filament blueprint"
 */
class TimestampColumn extends XotBaseTextColumn
{
    public static function make(?string $name = null): static
    {
        return parent::make($name ?? 'created_at')
            ->dateTime()
            ->sortable()
            ->placeholder('—');
    }
}
