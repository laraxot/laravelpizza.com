<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\Asz00fResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class Asz00fsTable extends XotBaseResourceTable
{
    /**
     * @return array<string, Column>
     */
    /**
    * @return array<string, Column>
    */
    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')
                ->sortable(),
            'ente' => TextColumn::make('ente')
                ->numeric()
                ->sortable(),
            'matr' => TextColumn::make('matr')
                ->numeric()
                ->sortable(),
            'asztip' => TextColumn::make('asztip')
                ->numeric()
                ->sortable(),
            'aszcod' => TextColumn::make('aszcod')
                ->numeric()
                ->sortable(),
            'aszdal' => TextColumn::make('aszdal')
                ->numeric()
                ->sortable(),
            'aszal' => TextColumn::make('aszal')
                ->numeric()
                ->sortable(),
            'aszumi' => TextColumn::make('aszumi')
                ->sortable(),
            'aszdur' => TextColumn::make('aszdur')
                ->sortable(),
            'asz2kd' => TextColumn::make('asz2kd')
                ->numeric()
                ->sortable(),
            'asz2ka' => TextColumn::make('asz2ka')
                ->numeric()
                ->sortable(),
        ];
    }
}
