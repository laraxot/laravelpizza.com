<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Widgets;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Modules\Geo\Models\Location;
use Modules\Xot\Filament\Widgets\XotBaseTableWidget as BaseWidget;

class LocationMapTableWidget extends BaseWidget
{
    protected static ?string $heading = 'Location Map';

    protected static ?int $sort = 1;

    protected static ?string $pollingInterval = null;

    public function table(Table $table): Table
    {
        return $table
            ->query(Location::query()->latest())
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('city')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('state')
                    ->searchable()
                    ->sortable(),
            ]);
    }
}
