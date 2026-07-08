<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources\StabiDirigenteResource\Pages;

use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Modules\Ptv\Filament\Resources\Pages\PtvBaseYearListRecords;
use Modules\Ptv\Filament\Resources\StabiDirigenteResource;
use Modules\UI\Filament\Tables\Columns\GroupColumn;

abstract class BaseListStabiDirigentes extends PtvBaseYearListRecords
{
    protected static string $resource = StabiDirigenteResource::class;

    /**
     * Get the table columns definition.
     *
     * @return array<string, Tables\Columns\Column>
     */
    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')
                ->sortable(),

            'valutatore_id' => TextColumn::make('valutatore_id')
                ->numeric()
                ->sortable(),
            'rep' => GroupColumn::make('rep')->schema([
                'stabi' => TextColumn::make('stabi')
                    ->searchable()
                    ->sortable(),

                'repar' => TextColumn::make('repar')
                    ->searchable()
                    ->sortable(),

                'nome_stabi' => TextColumn::make('nome_stabi')
                    ->searchable()
                    ->sortable(),
            ]),
            'diri' => GroupColumn::make('diri')->schema([
                'matr' => TextColumn::make('matr')
                    ->searchable()
                    ->sortable(),

                'nome_diri' => TextColumn::make('nome_diri')
                    ->searchable()
                    ->sortable(),

                'email' => TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
            ])->searchable(['matr', 'nome_diri', 'email']),
            'anno' => TextColumn::make('anno')
                ->numeric()
                ->sortable(),
        ];
    }
}
