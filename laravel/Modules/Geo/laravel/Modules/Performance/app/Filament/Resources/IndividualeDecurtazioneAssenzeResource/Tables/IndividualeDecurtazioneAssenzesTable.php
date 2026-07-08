<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\IndividualeDecurtazioneAssenzeResource\Tables;

use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Actions\Filament\Filter\GetYearFilter;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

use function Safe\date;

class IndividualeDecurtazioneAssenzesTable extends XotBaseResourceTable
{
    /**
     * @return array<string, mixed>
     */
    public function getTableColumns(): array
    {
        // Column types are inferred by Filament v4
        return [
            'id' => TextColumn::make('id')
                ->sortable(),
            'anno' => TextColumn::make('anno')
                ->sortable()
                ->searchable(),
            'individuale_id' => TextColumn::make('individuale.nome')
                ->sortable()
                ->searchable(),
            'min_perc' => TextColumn::make('min_perc')
                ->numeric()
                ->sortable(),
            'max_perc' => TextColumn::make('max_perc')
                ->numeric()
                ->sortable(),
            'min_gg_365' => TextColumn::make('min_gg_365')
                ->numeric()
                ->sortable(),
            'max_gg_365' => TextColumn::make('max_gg_365')
                ->numeric()
                ->sortable(),
            'decurtazione_perc' => TextColumn::make('decurtazione_perc')
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
            'anno' => app(GetYearFilter::class)
                ->execute('anno', intval(date('Y')) - 3, intval(date('Y'))),
        ];
    }
}
