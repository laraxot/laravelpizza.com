<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\IndividualeTotStabiResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Performance\Filament\Resources\IndividualeTotStabiResource;
use Modules\Ptv\Filament\Actions\Header\CopyFromLastYearAction;
use Modules\Ptv\Filament\Resources\Pages\PtvBaseYearListRecords;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Override;

class ListIndividualeTotStabis extends PtvBaseYearListRecords
{
    protected static string $resource = IndividualeTotStabiResource::class;

   

    #[Override]
    /**
     * @return array<string, mixed>
     */
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
}
