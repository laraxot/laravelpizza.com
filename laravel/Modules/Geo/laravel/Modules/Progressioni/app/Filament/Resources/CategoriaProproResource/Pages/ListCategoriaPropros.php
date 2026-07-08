<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\CategoriaProproResource\Pages;

use Filament\Tables\Columns\TextColumn;
use Modules\Progressioni\Filament\Resources\CategoriaProproResource;
use Modules\Ptv\Filament\Resources\Pages\PtvBaseYearListRecords;
use Override;

class ListCategoriaPropros extends PtvBaseYearListRecords
{
    protected static string $resource = CategoriaProproResource::class;

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
            'categoria' => TextColumn::make('categoria')
                ->searchable()
                ->sortable(),
            'lista_propro' => TextColumn::make('lista_propro')
                ->searchable()
                ->sortable(),
            'lista_propro_sup' => TextColumn::make('lista_propro_sup')
                ->searchable()
                ->sortable(),
            'posti' => TextColumn::make('posti')
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
