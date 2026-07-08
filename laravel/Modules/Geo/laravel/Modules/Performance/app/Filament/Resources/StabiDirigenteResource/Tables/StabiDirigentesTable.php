<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\StabiDirigenteResource\Tables;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\BaseFilter;
use Modules\UI\Filament\Tables\Columns\GroupColumn;
use Modules\Xot\Actions\Filament\Filter\GetYearFilter;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

use function Safe\date;

class StabiDirigentesTable extends XotBaseResourceTable
{
    /**
     * @return array<int|string, Action|ActionGroup>
     */
    public function getTableHeaderActions(): array
    {
        return parent::getTableHeaderActions();
    }

    /**
     *  array<string, Column>
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

    /**
     *  array<string, BaseFilter>
     */
    public function getTableFilters(): array
    {
        return [
            'anno' => app(GetYearFilter::class)
                ->execute('anno', intval(date('Y')) - 3, intval(date('Y'))),
        ];
    }
}
