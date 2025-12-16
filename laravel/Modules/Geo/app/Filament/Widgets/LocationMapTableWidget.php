<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Widgets;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Modules\Geo\Models\Location;

class LocationMapTableWidget extends BaseWidget
{
    protected static ?string $heading = 'Location Map';

    protected static ?int $sort = 1;

    protected static ?string $pollingInterval = null;

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getTableQuery())
            ->columns($this->getTableColumns());
    }

    protected function getTableQuery(): Builder
    {
        return Location::query()->latest();
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('name')
                ->searchable()
                ->sortable(),
            TextColumn::make('city')
                ->searchable()
                ->sortable(),
            TextColumn::make('state')
                ->searchable()
                ->sortable(),
        ];
    }
}
