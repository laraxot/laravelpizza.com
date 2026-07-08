<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\OrganizzativaResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Modules\Performance\Filament\Actions\Header\CopyFromIndividualeAction;
use Modules\Performance\Filament\Actions\Header\CopyValutatoreIdFromIndividualeAction;
use Modules\Performance\Filament\Resources\OrganizzativaResource;
use Modules\Performance\Models\StabiDirigente;
use Modules\Ptv\Enums\WorkerType;
use Modules\Ptv\Filament\Columns\LavoratoreColumn;
use Modules\Ptv\Filament\Columns\PeriodoColumn;
use Modules\Ptv\Filament\Columns\QualificaColumn;
use Modules\Ptv\Filament\Columns\RepartoColumn;
use Modules\Ptv\Filament\Resources\SchedaResource\Pages\ListScheda;
use Modules\UI\Filament\Tables\Columns\GroupColumn;
use Modules\Xot\Actions\Filament\Filter\GetYearFilter;

use function Safe\date;

/**
 * ---.
 */
class ListOrganizzativas extends ListScheda
{
    protected static string $resource = OrganizzativaResource::class;

    /*

    public function getTableColumns(): array
    {
       // Column types are inferred by Filament v4
       return [
           'type' => TextColumn::make('type')
               ->searchable(),
           'valutatore_id' => SelectColumn::make('valutatore_id')
               ->options(function ($record) {
                   // Type narrowing: ensure record is Model and has anno property
                   if (! is_object($record) || ! isset($record->anno)) {
                       return [];
                   }
                   $anno = is_int($record->anno) ? $record->anno : (int) $record->anno;

                   return StabiDirigente::where('anno', $anno)->whereRaw('id=valutatore_id')->pluck('nome_diri', 'id');
               })
               ->visible(auth()->user()?->isSuperAdmin() ?? false),

           'ha_diritto' => ToggleColumn::make('ha_diritto')
               ->searchable(),
           'motivo' => TextColumn::make('motivo')
               ->searchable(),
           'soldi_group' => GroupColumn::make('soldi')->schema([
               'importo_totale' => TextColumn::make('importo_totale'),
               'resti' => TextColumn::make('resti'),
               'resti_pond' => TextColumn::make('resti_pond'),
               'budget_assegnato' => TextColumn::make('budget_assegnato'),
               'quota_effettiva' => TextColumn::make('quota_effettiva'),
           ]),

           'lavoratore' => LavoratoreColumn::make('lavoratore'),
           'info_group' => GroupColumn::make('info')->schema([
               'perc_parttimepond_dalal' => TextColumn::make('perc_parttimepond_dalal'),
               'gg_presenza_dalal' => TextColumn::make('gg_presenza_dalal'),
               'gg_assenza_dalal' => TextColumn::make('gg_assenza_dalal'),
               'hh_assenza_dalal' => TextColumn::make('hh_assenza_dalal'),
               'quota_teorica' => TextColumn::make('quota_teorica'),
               'budget_assegnato' => TextColumn::make('budget_assegnato'),
               'quota_effettiva' => TextColumn::make('quota_effettiva'),
           ]),

           'qualifica' => QualificaColumn::make('qualifica'),
           'reparto' => RepartoColumn::make('reparto'),
           'periodo' => PeriodoColumn::make('periodo'),
       ];
    }

    public function getTableFilters(): array
    {
       return [
           'anno' => app(GetYearFilter::class)->execute('anno', intval(date('Y')) - 3, intval(date('Y'))),
           'ha_diritto' => TernaryFilter::make('ha_diritto'),
           'type' => SelectFilter::make('type')
               ->options(WorkerType::class),
       ];
    }
    */
    /**
     * @return array<string, Action|ActionGroup>
     */
    protected function getHeaderActions(): array
    {
        return [
            ...parent::getHeaderActions(),
            // Azione custom per copia valutatore_id da Individuale a Organizzativa (nome unico obbligatorio)
            'copy_valutatore_id_from_individuale' => CopyValutatoreIdFromIndividualeAction::make('copy_valutatore_id_from_individuale'),
            'copy_from_individuale' => CopyFromIndividualeAction::make('copy_from_individuale'),
        ];
    }
}
