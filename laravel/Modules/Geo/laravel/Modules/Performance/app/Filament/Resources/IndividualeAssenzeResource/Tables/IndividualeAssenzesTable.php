<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\IndividualeAssenzeResource\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class IndividualeAssenzesTable extends XotBaseResourceTable
{
    /**
     * @return array<string, mixed>
     */
    public function getTableColumns(): array
    {
        // Column types are inferred by Filament v4
        return [
            'tipo' => TextColumn::make('tipo')
                ->numeric()
                ->sortable(),
            'codice' => TextColumn::make('codice')
                ->numeric()
                ->sortable(),
            'descr' => TextColumn::make('descr')
                ->searchable()
                ->wrap(),
            'anno' => TextColumn::make('anno')
                ->numeric()
                ->sortable(),
            'created_at' => TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            'updated_at' => TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function getTableFilters(): array
    {
        return [
            'tipo' => SelectFilter::make('tipo')
                ->searchable()
                ->preload(),
            'codice' => SelectFilter::make('codice')
                ->searchable()
                ->preload(),
        ];
    }
}
