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
class ValutatoreColumn extends GroupColumn
{
    protected function setUp(): void
    {
        parent::setUp();
        // $searchable = ['valutatore_id', 'valutatore.nome_diri', 'valutatore.anno', 'valutatore.quadrimestre'];
        $searchable = [];
        // Pre-configure the schema with worker fields
        $this->schema([
            TextColumn::make('valutatore_id'),
            TextColumn::make('valutatore.nome_diri'),
            TextColumn::make('valutatore.anno'),
            TextColumn::make('valutatore.quadrimestre'),
        ])->searchable($searchable);
    }
}
