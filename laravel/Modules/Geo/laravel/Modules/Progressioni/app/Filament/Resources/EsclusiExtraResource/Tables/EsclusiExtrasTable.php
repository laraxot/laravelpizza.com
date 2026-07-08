<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\EsclusiExtraResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class EsclusiExtrasTable extends XotBaseResourceTable
{
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
