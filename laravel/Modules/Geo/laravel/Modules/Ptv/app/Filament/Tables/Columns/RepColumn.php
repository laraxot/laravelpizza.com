<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Tables\Columns;

use Filament\Tables\Columns\TextColumn;
use Modules\UI\Filament\Tables\Columns\GroupColumn;

/**
 * RepColumn - Encapsulates the common department/workplace fields pattern.
 *
 * Usage: RepColumn::make('rep')
 *
 * This automatically creates a grouped column with:
 * - stabi (stabilimento)
 * - stabi_txt (stabilimento description)
 * - repar (reparto)
 * - repar_txt (reparto description)
 */
class RepColumn extends GroupColumn
{
    protected function setUp(): void
    {
        parent::setUp();

        // Pre-configure the schema with rep fields
        $this->schema([
            TextColumn::make('stabi'),
            TextColumn::make('stabi_txt'),
            TextColumn::make('repar'),
            TextColumn::make('repar_txt'),
        ]);
    }
}
