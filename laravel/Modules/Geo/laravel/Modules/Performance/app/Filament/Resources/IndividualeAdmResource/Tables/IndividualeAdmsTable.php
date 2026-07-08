<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\IndividualeAdmResource\Tables;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Modules\Performance\Actions\ShowMailSendedAt;
use Modules\Performance\Models\StabiDirigente;
use Modules\Ptv\Enums\WorkerType;
use Modules\Ptv\Filament\Actions\Bulk\SendMailBulkAction;
use Modules\Ptv\Filament\Actions\Bulk\ZipSchedaBulkAction;
use Modules\Ptv\Filament\Actions\Header\CopyFromLastYearAction;
use Modules\Ptv\Filament\Actions\Scheda\CompilaAction;
use Modules\Ptv\Filament\Columns\LavoratoreColumn;
use Modules\Ptv\Filament\Columns\PeriodoColumn;
use Modules\Ptv\Filament\Columns\QualificaColumn;
use Modules\Ptv\Filament\Columns\RepartoColumn;
use Modules\Ptv\Models\Contracts\SchedaContract;
use Modules\UI\Filament\Tables\Columns\GroupColumn;
use Modules\Xot\Filament\Actions\Table\PdfAction;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

use function Safe\date;

class IndividualeAdmsTable extends XotBaseResourceTable
{
    /**
     * @return array<int|string, Action|ActionGroup>
     */
    public function getTableHeaderActions(): array
    {
        $actions = parent::getTableHeaderActions();
        $actions['copy'] = CopyFromLastYearAction::make();

        return $actions;
    }

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
            ...$this->getSchedaListTableColumns(),
        ];
    }

    /**
     * Colonne condivise con ListScheda (sostituisce parent::getTableColumns() su XotBaseResourceTable).
     *
     * @return array<string, Column>
     */
    private function getSchedaListTableColumns(): array
    {
        return [
            'id_motivo' => GroupColumn::make('id/motivo')->schema([
                'scheda_id' => TextColumn::make('id'),
                'motivo' => TextColumn::make('motivo'),
            ])->searchable(['motivo']),
            'ha_diritto' => IconColumn::make('ha_diritto')->boolean(),
            'mail_sended_at' => TextColumn::make('mail_sended_at')
                ->html()
                ->default(fn (SchedaContract $record): string => app(ShowMailSendedAt::class)->execute($record)),
            'lavoratore' => LavoratoreColumn::make('lavoratore')->appendColumns([]),
            'qualifica' => QualificaColumn::make('qualifica'),
            'reparto' => RepartoColumn::make('reparto'),
            'periodo' => PeriodoColumn::make('periodo'),
            'valutatore_id' => SelectColumn::make('valutatore_id')
                ->label('valutatore')
                ->options(function (mixed $record): array {
                    if (! is_object($record) || ! isset($record->anno)) {
                        return [];
                    }

                    $anno = $record->anno;

                    return StabiDirigente::query()
                        ->where('anno', $anno)
                        ->whereRaw('id=valutatore_id')
                        ->pluck('nome_diri', 'id')
                        ->toArray();
                })
                ->visible(auth()->user()?->isSuperAdmin() ?? false),
        ];
    }

    /**
     * @return array<string, Filter|SelectFilter|TernaryFilter>
     */
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

    public function getTableActions(): array
    {
        return [
            ...parent::getTableActions(),
            'compila' => CompilaAction::make()
                ->visible(function (SchedaContract $record): bool {
                    // @var bool|null $haDiritto
                    return (int) $record->ha_diritto > 0;
                }),
            'pdf' => PdfAction::make('pdf')
                ->visible(function (SchedaContract $record): bool {
                    /* @var bool|null $haDiritto */
                    return (int) $record->ha_diritto > 0;
                }),
        ];
    }

    public function getTableBulkActions(): array
    {
        return [
            'send_mail' => SendMailBulkAction::make('send_mail'),
            'zip_schede' => ZipSchedaBulkAction::make('zip_schede'),
        ];
    }
}
