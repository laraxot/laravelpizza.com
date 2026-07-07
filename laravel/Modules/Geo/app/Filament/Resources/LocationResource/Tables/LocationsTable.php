<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Resources\LocationResource\Tables;

<<<<<<< HEAD
=======
use Filament\Tables\Columns\Column;
>>>>>>> 40b96bcd6 (.)
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class LocationsTable extends XotBaseResourceTable
{
<<<<<<< HEAD
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
=======
    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')->sortable(),
            'name' => TextColumn::make('name')->searchable(),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
>>>>>>> 40b96bcd6 (.)
        ];
    }
}
