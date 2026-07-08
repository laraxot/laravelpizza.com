<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\IndividualeAdmResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Modules\Performance\Filament\Resources\IndividualeAdmResource;
use Modules\Performance\Models\StabiDirigente;
use Modules\Ptv\Enums\WorkerType;
use Modules\Ptv\Filament\Actions\Header\CopyFromLastYearAction;
use Modules\Ptv\Filament\Columns\LavoratoreColumn;
use Modules\Ptv\Filament\Columns\PeriodoColumn;
use Modules\Ptv\Filament\Columns\QualificaColumn;
use Modules\Ptv\Filament\Columns\RepartoColumn;
use Modules\Ptv\Filament\Resources\SchedaResource\Pages\ListScheda;
use Modules\UI\Filament\Tables\Columns\GroupColumn;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Override;

use function Safe\date;

class ListIndividualeAdms extends ListScheda
{
    protected static string $resource = IndividualeAdmResource::class;

   

   #[Override]
    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id'),
            'type' => TextColumn::make('type')
                ->badge()
                ->searchable(),
            'soldi_group' => GroupColumn::make('soldi')->schema([
                'importo_totale' => TextColumn::make('importo_totale'),
                'resti' => TextColumn::make('resti'),
                'resti_pond' => TextColumn::make('resti_pond'),
                'budget_assegnato' => TextColumn::make('budget_assegnato'),
                'quota_effettiva' => TextColumn::make('quota_effettiva'),
            ]),
            'info_group' => GroupColumn::make('info')->schema([
                'perc_parttimepond_dalal' => TextColumn::make('perc_parttimepond_dalal'),
                'gg_presenza_dalal' => TextColumn::make('gg_presenza_dalal'),
                'gg_assenza_dalal' => TextColumn::make('gg_assenza_dalal'),
                'hh_assenza_dalal' => TextColumn::make('hh_assenza_dalal'),
                'quota_teorica' => TextColumn::make('quota_teorica'),
                'budget_assegnato' => TextColumn::make('budget_assegnato'),
                'quota_effettiva' => TextColumn::make('quota_effettiva'),
                'resti' => TextColumn::make('resti'),
                'resti_pond' => TextColumn::make('resti_pond'),
                'importo_totale' => TextColumn::make('importo_totale'),
            ]),
            ...parent::getTableColumns(),
        ];
    }

    #[Override]
    public function getTableFilters(): array
    {
        return [
            'anno' => SelectFilter::make('anno')
                ->options(function () {
                    $currentYear = (int) date('Y');

                    return [
                        $currentYear => $currentYear,
                        $currentYear - 1 => $currentYear - 1,
                        $currentYear - 2 => $currentYear - 2,
                    ];
                }),
            'ha_diritto' => TernaryFilter::make('ha_diritto'),
            'type' => SelectFilter::make('type')
                ->options(WorkerType::class),
        ];
    }

    /**
     * Get the header actions for the list page.
     *
     * @return array<string, Action|ActionGroup>
     */
    #[Override]
    public function getHeaderActions(): array
    {
        $actions = parent::getHeaderActions();
        $actions['copy'] = CopyFromLastYearAction::make();

        return $actions;
    }
}
