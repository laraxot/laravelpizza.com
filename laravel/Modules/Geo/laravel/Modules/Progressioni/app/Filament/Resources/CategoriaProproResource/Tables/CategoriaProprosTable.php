<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\CategoriaProproResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class CategoriaProprosTable extends XotBaseResourceTable
{
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
