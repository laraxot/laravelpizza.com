<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\IndividualeDecurtazioneAssenzeResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Performance\Filament\Resources\IndividualeDecurtazioneAssenzeResource;
use Modules\Ptv\Filament\Actions\Header\CopyFromLastYearAction;
use Modules\Ptv\Filament\Resources\Pages\PtvBaseYearListRecords;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Override;

class ListIndividualeDecurtazioneAssenzes extends PtvBaseYearListRecords
{
    protected static string $resource = IndividualeDecurtazioneAssenzeResource::class;

    #[Override]
    /**
     * @return array<string, mixed>
     */
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

   
}
