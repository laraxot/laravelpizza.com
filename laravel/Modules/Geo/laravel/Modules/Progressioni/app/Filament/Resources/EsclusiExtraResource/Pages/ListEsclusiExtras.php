<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\EsclusiExtraResource\Pages;

use Filament\Tables\Columns\TextColumn;
use Modules\Progressioni\Filament\Resources\EsclusiExtraResource;
use Modules\Ptv\Filament\Resources\Pages\PtvBaseYearListRecords;
use Override;

class ListEsclusiExtras extends PtvBaseYearListRecords
{
    protected static string $resource = EsclusiExtraResource::class;

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
            'ente' => TextColumn::make('ente')
                ->numeric()
                ->sortable(),
            'matr' => TextColumn::make('matr')
                ->searchable()
                ->sortable(),
            'cognome' => TextColumn::make('cognome')
                ->searchable()
                ->sortable(),
            'nome' => TextColumn::make('nome')
                ->searchable()
                ->sortable(),
            'motivo' => TextColumn::make('motivo')
                ->searchable()
                ->sortable()
                ->wrap(),
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
