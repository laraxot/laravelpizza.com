<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\StipendioTabellareResource\Pages;

use Filament\Tables\Columns\TextColumn;
use Modules\Progressioni\Filament\Resources\StipendioTabellareResource;
use Modules\Ptv\Filament\Resources\Pages\PtvBaseYearListRecords;
use Override;

class ListStipendioTabellares extends PtvBaseYearListRecords
{
    protected static string $resource = StipendioTabellareResource::class;

    #[Override]
    /**
     * @return array<string, mixed>
     */
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
            'importo' => TextColumn::make('importo')
                ->numeric()
                ->sortable(),
            'anno' => TextColumn::make('anno')
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
