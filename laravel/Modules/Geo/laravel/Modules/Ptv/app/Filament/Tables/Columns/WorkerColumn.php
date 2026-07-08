<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Tables\Columns;

use Filament\Tables\Columns\TextColumn;
use Modules\UI\Filament\Tables\Columns\GroupColumn;

/**
 * WorkerColumn - Encapsulates the common worker fields pattern.
 *
 * Usage: WorkerColumn::make('lavoratore')
 *
 * This automatically creates a grouped column with:
 * - matr (searchable)
 * - cognome (searchable)
 * - nome
 * - email
 *
 * All fields are searchable at the group level.
 */
class WorkerColumn extends GroupColumn
{
    protected function setUp(): void
    {
        parent::setUp();

        // Pre-configure the schema with worker fields
        $this->schema([
            TextColumn::make('matr')->searchable(),
            TextColumn::make('cognome')->searchable(),
            TextColumn::make('nome'),
            TextColumn::make('email'),
        ])->searchable(['matr', 'cognome', 'nome', 'email']);
    }
}
