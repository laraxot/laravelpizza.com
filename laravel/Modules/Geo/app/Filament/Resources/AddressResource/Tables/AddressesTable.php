<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Resources\AddressResource\Tables;

<<<<<<< HEAD
=======
use Filament\Tables\Columns\Column;
>>>>>>> 40b96bcd6 (.)
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class AddressesTable extends XotBaseResourceTable
{
<<<<<<< HEAD
    public static function getTableColumns(): array
=======
    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
>>>>>>> 40b96bcd6 (.)
    {
        return [
            'name' => TextColumn::make('name')->searchable(),
            'route' => TextColumn::make('route'),
            'locality' => TextColumn::make('locality')->searchable(),
            'comune' => TextColumn::make('administrative_area_level_3'),
            'provincia' => TextColumn::make('administrative_area_level_2'),
            'postal_code' => TextColumn::make('postal_code'),
            'type' => TextColumn::make('type'),
            'is_primary' => TextColumn::make('is_primary')->badge(),
        ];
    }
}
