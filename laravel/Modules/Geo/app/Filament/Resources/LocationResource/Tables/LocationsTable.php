<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Resources\LocationResource\Tables;

use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class LocationsTable extends XotBaseResourceTable
{
    public static function getTableColumns(): array
    {
        return [
            'name' => TextColumn::make('name')->searchable()->sortable(),
            'city' => TextColumn::make('city')->searchable(),
            'state' => TextColumn::make('state'),
            'zip' => TextColumn::make('zip'),
            'lat' => TextColumn::make('lat'),
            'lng' => TextColumn::make('lng'),
            'processed' => TextColumn::make('processed')->badge(),
        ];
    }
}
