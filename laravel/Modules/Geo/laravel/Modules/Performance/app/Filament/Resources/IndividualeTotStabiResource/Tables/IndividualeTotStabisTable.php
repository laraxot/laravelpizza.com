<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\IndividualeTotStabiResource\Tables;

use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Actions\Filament\Filter\GetYearFilter;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

use function Safe\date;

class IndividualeTotStabisTable extends XotBaseResourceTable
{
    /**
     * @return array<string, mixed>
     */
    public function getTableColumns(): array
    {
        // Column types are inferred by Filament v4
        return [
            'stabi' => TextColumn::make('stabi')
                ->numeric()
                ->sortable(),
            'tot_budget_assegnato' => TextColumn::make('tot_budget_assegnato')
                ->numeric()
                ->sortable(),
            'tot_budget_assegnato_min_punteggio' => TextColumn::make('tot_budget_assegnato_min_punteggio')
                ->numeric()
                ->sortable(),
            'tot_quota_effettiva' => TextColumn::make('tot_quota_effettiva')
                ->numeric()
                ->sortable(),
            'tot_quota_effettiva_min_punteggio' => TextColumn::make('tot_quota_effettiva_min_punteggio')
                ->numeric()
                ->sortable(),
            'tot_resti' => TextColumn::make('tot_resti')
                ->numeric()
                ->sortable(),
            'tot_resti_min_punteggio' => TextColumn::make('tot_resti_min_punteggio')
                ->numeric()
                ->sortable(),
            'delta' => TextColumn::make('delta')
                ->numeric()
                ->sortable(),
            'delta_min_punteggio' => TextColumn::make('delta_min_punteggio')
                ->numeric()
                ->sortable(),
            'anno' => TextColumn::make('anno')
                ->numeric()
                ->sortable(),
            'n_diritto' => TextColumn::make('n_diritto')
                ->numeric()
                ->sortable(),
            'n_diritto_excellence' => TextColumn::make('n_diritto_excellence')
                ->numeric()
                ->sortable(),
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
