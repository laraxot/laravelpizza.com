<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\MaxCatecoPosfunAnnoResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class MaxCatecoPosfunAnnosTable extends XotBaseResourceTable
{
    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')
                ->sortable(),
            'cateco' => TextColumn::make('cateco')
                ->searchable()
                ->sortable(),
            'posfun' => TextColumn::make('posfun')
                ->searchable()
                ->sortable(),
            'anno' => TextColumn::make('anno')
                ->numeric()
                ->sortable(),
            'max_gg_tot_pond' => TextColumn::make('max_gg_tot_pond')
                ->sortable(),
            'aventi_diritto' => TextColumn::make('aventi_diritto')
                ->numeric()
                ->sortable(),
            'aventi_diritto_perc' => TextColumn::make('aventi_diritto_perc')
                ->numeric()
                ->sortable(),
            'aventi_diritto_eff' => TextColumn::make('aventi_diritto_eff')
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
}
