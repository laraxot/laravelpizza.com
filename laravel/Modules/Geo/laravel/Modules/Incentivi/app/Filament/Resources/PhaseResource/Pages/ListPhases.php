<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\PhaseResource\Pages;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Incentivi\Filament\Resources\PhaseResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Override;

class ListPhases extends XotBaseListRecords
{
    protected static string $resource = PhaseResource::class;

    #[Override]
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
