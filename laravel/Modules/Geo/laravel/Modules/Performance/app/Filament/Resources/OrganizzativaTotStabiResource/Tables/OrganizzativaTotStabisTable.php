<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\OrganizzativaTotStabiResource\Tables;

use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Actions\Filament\Filter\GetYearFilter;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

use function Safe\date;

class OrganizzativaTotStabisTable extends XotBaseResourceTable
{
    /**
     * @return array<string, mixed>
     */
    public function getTableColumns(): array
    {
        // Column types are inferred by Filament v4
        return [
            'stabi' => TextColumn::make('stabi')
                ->label('Stabilimento')
                ->numeric()
                ->sortable(),
            'tot_budget_assegnato' => TextColumn::make('tot_budget_assegnato')
                ->label('Budget Assegnato')
                ->numeric()
                ->sortable(),
            'tot_budget_assegnato_min_punteggio' => TextColumn::make('tot_budget_assegnato_min_punteggio')
                ->label('Budget Min Punteggio')
                ->numeric()
                ->sortable(),
            'tot_quota_effettiva' => TextColumn::make('tot_quota_effettiva')
                ->label('Quota Effettiva')
                ->numeric()
                ->sortable(),
            'tot_quota_effettiva_min_punteggio' => TextColumn::make('tot_quota_effettiva_min_punteggio')
                ->label('Quota Min Punteggio')
                ->numeric()
                ->sortable(),
            'tot_resti' => TextColumn::make('tot_resti')
                ->label('Resti')
                ->numeric()
                ->sortable(),
            'tot_resti_min_punteggio' => TextColumn::make('tot_resti_min_punteggio')
                ->label('Resti Min Punteggio')
                ->numeric()
                ->sortable(),
            'delta' => TextColumn::make('delta')
                ->label('Delta')
                ->numeric()
                ->sortable(),
            'delta_min_punteggio' => TextColumn::make('delta_min_punteggio')
                ->label('Delta Min Punteggio')
                ->numeric()
                ->sortable(),
            'anno' => TextColumn::make('anno')
                ->label('Anno')
                ->numeric()
                ->sortable(),
            'created_at' => TextColumn::make('created_at')
                ->label('Data Creazione')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            'updated_at' => TextColumn::make('updated_at')
                ->label('Ultima Modifica')
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
            'anno' => app(GetYearFilter::class)
                ->execute('anno', intval(date('Y')) - 3, intval(date('Y'))),
        ];
    }
}
