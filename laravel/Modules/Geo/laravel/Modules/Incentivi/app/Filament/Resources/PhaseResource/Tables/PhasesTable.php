<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\PhaseResource\Tables;

use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class PhasesTable extends XotBaseResourceTable
{
    /**
     * @return array<string, mixed>
     */
    public function getTableColumns(): array
    {
        // Column types are inferred by Filament v4
        return [
            'name' => TextColumn::make('name')
                ->searchable()
                ->sortable(),
            'description' => TextColumn::make('description')
                ->searchable()
                ->sortable(),
            'start_date' => TextColumn::make('start_date')
                ->searchable()
                ->sortable(),
            'end_date' => TextColumn::make('end_date')
                ->searchable()
                ->sortable(),
            'settlement' => TextColumn::make('settlement.denominazione'),
        ];
    }
}
