<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Resources\Pages;

use Filament\Tables\Columns\TextColumn;
use Modules\Geo\Filament\Resources\LocationResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListLocations extends XotBaseListRecords
{
    protected static string $resource = LocationResource::class;

    public function getTableComumns(): array
    {
        return [
            TextColumn::make('name')->searchable(),
            TextColumn::make('street'),
            TextColumn::make('city')->searchable(),
            TextColumn::make('state')->searchable(),
            TextColumn::make('zip'),
        ];
    }
}
