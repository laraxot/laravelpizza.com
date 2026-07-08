<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\ValutatoreResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class ValutatoresTable extends XotBaseResourceTable
{
    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')
                ->sortable(),
            'stabi' => TextColumn::make('stabi')
                ->numeric()
                ->sortable(),
            'repar' => TextColumn::make('repar')
                ->numeric()
                ->sortable(),
            'nome_stabi' => TextColumn::make('nome_stabi')
                ->searchable()
                ->sortable(),
            'stabi_txt' => TextColumn::make('stabi_txt')
                ->searchable()
                ->sortable(),
            'repar_txt' => TextColumn::make('repar_txt')
                ->searchable()
                ->sortable(),
            'ente' => TextColumn::make('ente')
                ->numeric()
                ->sortable(),
            'matr' => TextColumn::make('matr')
                ->numeric()
                ->sortable(),
            'anno' => TextColumn::make('anno')
                ->numeric()
                ->sortable(),
            'nome_diri' => TextColumn::make('nome_diri')
                ->searchable()
                ->sortable(),
            'nome_diri_plus' => TextColumn::make('nome_diri_plus')
                ->searchable()
                ->sortable(),
            'budget' => TextColumn::make('budget')
                ->numeric()
                ->sortable(),
            'valutatore_id' => TextColumn::make('valutatore_id')
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
