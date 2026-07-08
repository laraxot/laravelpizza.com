<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\CriteriMaggiorazioneResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Actions;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Modules\Performance\Filament\Resources\CriteriMaggiorazioneResource;
use Modules\Ptv\Filament\Actions\Header\CopyFromLastYearAction;
use Modules\Ptv\Filament\Resources\Pages\PtvBaseYearListRecords;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Override;

use function Safe\date;

class ListCriteriMaggioraziones extends PtvBaseYearListRecords
{
    protected static string $resource = CriteriMaggiorazioneResource::class;

    #[Override]
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

  
}
