<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\IndividualeCatCoeffResource\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class IndividualeCatCoeffsTable extends XotBaseResourceTable
{
    /**
     * @return array<string, mixed>
     */
    public function getTableColumns(): array
    {
        return [
            'lista_propro' => TextColumn::make('lista_propro')
                ->searchable(),
            'coeff' => TextColumn::make('coeff')
                ->numeric()
                ->sortable(),
            'descr' => TextColumn::make('descr')
                ->searchable()
                ->wrap(),
            'tot_giorni' => TextColumn::make('tot_giorni')
                ->numeric()
                ->sortable(),
            'tot_giorni_pt' => TextColumn::make('tot_giorni_pt')
                ->numeric()
                ->sortable(),
            'tot_giorni_pt_coeff' => TextColumn::make('tot_giorni_pt_coeff')
                ->numeric()
                ->sortable(),
            'quota_teorica' => TextColumn::make('quota_teorica')
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

    /**
     * @return array<string, mixed>
     */
    public function getTableFilters(): array
    {
        return [
            'lista_propro' => SelectFilter::make('lista_propro')
                ->searchable()
                ->preload(),
        ];
    }
}
