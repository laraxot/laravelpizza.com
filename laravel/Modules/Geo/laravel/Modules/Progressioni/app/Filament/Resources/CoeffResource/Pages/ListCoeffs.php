<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\CoeffResource\Pages;

use Filament\Tables\Columns\TextColumn;
use Modules\Progressioni\Filament\Resources\CoeffResource;
use Modules\Ptv\Filament\Resources\Pages\PtvBaseYearListRecords;
use Override;

class ListCoeffs extends PtvBaseYearListRecords
{
    protected static string $resource = CoeffResource::class;

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
            'name' => TextColumn::make('name')
                ->searchable()
                ->sortable(),
            'value' => TextColumn::make('value')
                ->searchable()
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
