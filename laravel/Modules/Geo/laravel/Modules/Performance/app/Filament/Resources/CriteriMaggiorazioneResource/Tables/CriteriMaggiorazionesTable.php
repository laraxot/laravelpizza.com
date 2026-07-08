<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\CriteriMaggiorazioneResource\Tables;

use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Actions\Filament\Filter\GetYearFilter;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

use function Safe\date;

class CriteriMaggiorazionesTable extends XotBaseResourceTable
{
    /**
     * @return array<string, mixed>
     */
    public function getTableColumns(): array
    {
        // Column types are inferred by Filament v4
        return [
            'anno' => TextColumn::make('anno')
                ->label('Anno')
                ->numeric()
                ->sortable(),
            'min_valutaz_perf_ind' => TextColumn::make('min_valutaz_perf_ind')
                ->label('Valutazione Performance Individuale Minima')
                ->numeric()
                ->sortable(),
            'maggiorazione_perc' => TextColumn::make('maggiorazione_perc')
                ->label('Percentuale Maggiorazione')
                ->numeric()
                ->sortable()
                ->suffix('%'),
            'created_at' => TextColumn::make('created_at')
                ->label('Data Creazione')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            'updated_at' => TextColumn::make('updated_at')
                ->label('Ultima Modifica')
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
