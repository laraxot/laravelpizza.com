<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\ProgressioniResource\Tables;

use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Tables;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Modules\Activity\Filament\Actions\ListLogActivitiesAction;
use Modules\Progressioni\Actions\ShowMailSendedAt;
use Modules\Progressioni\Filament\Actions\Bulk\SendMailBulkAction;
use Modules\Progressioni\Filament\Actions\Header\RicalcolaAction;
use Modules\Progressioni\Models\Progressioni;
use Modules\Ptv\Actions\GetValutatoriOptions;
use Modules\Ptv\Filament\Actions\Bulk\ZipSchedaBulkAction;
use Modules\Ptv\Filament\Actions\Header\MergeDoubleRowCatecoYearAction;
use Modules\Ptv\Filament\Actions\Header\PopulateYearAction;
use Modules\Ptv\Filament\Columns\QuaColumn;
use Modules\Ptv\Filament\Columns\RepartoColumn;
use Modules\Ptv\Filament\Columns\WorkerColumn;
use Modules\UI\Filament\Tables\Columns\GroupColumn;
use Modules\Xot\Filament\Actions\Header\ExportXlsAction;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class ProgressionisTable extends XotBaseResourceTable
{
    /**
     * Convertito da ListProgressionis::getHeaderActions() al contesto classe Table:
     * - metodo `getTableHeaderActions()` (cablato da HasXotTable::table() in ->headerActions())
     * - lettura filtri via `$this->tableFilters` + `Arr::get('anno/valutatore')` (pattern SchedasTable)
     *
     * @return array<string, Action>
     */
    public function getTableHeaderActions(): array
    {
        /** @var array<string, mixed> $tableFilters */
        $tableFilters = $this->tableFilters ?? [];
        /** @var array<string, mixed> $annoValutatoreFilter */
        $annoValutatoreFilter = Arr::get($tableFilters, 'anno/valutatore', []);
        /** @var int|string|null $anno */
        $anno = Arr::get($annoValutatoreFilter, 'anno');

        if ($anno != null) {
            Progressioni::where('anno', $anno)
                ->whereNull('ha_diritto')
                ->whereNull('motivo')
                ->update(['ha_diritto' => 1]);
        }

        return [
            'populate' => PopulateYearAction::make(),
            'merge' => MergeDoubleRowCatecoYearAction::make(),
            'export' => ExportXlsAction::make(),
            'ricalcola' => RicalcolaAction::make(),
        ];
    }

    /**
    * @return array<string, Column>
    */
    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id'),
            'cognome' => TextColumn::make('cognome')->toggleable(isToggledHiddenByDefault: true)->searchable(),
            'matr' => TextColumn::make('matr')->toggleable(isToggledHiddenByDefault: true)->searchable(),

            'ha_diritto' => IconColumn::make('ha_diritto')
                ->default(false)
                ->boolean(),

            'motivo' => TextColumn::make('motivo')
                // ->searchable() //diventa troppo lento
                ->wrap(),
            /* --------------------------- TROPPE QUERY ---------------------------- */
            /*
            Tables\Columns\TextColumn::make('mail_sended_at')
                ->html()
                ->default(fn ($record) => app(ShowMailSendedAt::class)->execute($record)),
            // */
            // ->formatStateUsing(fn (string $state) => dddx($state)),

            /*
                'diritto' => GroupColumn::make('diritto')->schema([
                    //Tables\Columns\TextColumn::make('ha_diritto'),
                    'ha_diritto' => IconColumn::make('ha_diritto')
                        ->default(false)
                        ->boolean(),
                    Tables\Columns\TextColumn::make('motivo')
                        ->wrap()
                        //->formatStateUsing(fn (string $state) => dddx($state))
                        //->listWithLineBreaks()
                        //->badge()
                        //->separator(','),
                ]),
                */
            'lavoratore' => WorkerColumn::make('lavoratore'),
            'criteri' => GroupColumn::make('criteri')->schema([
                'gg' => TextColumn::make('gg'),
                'gg_no_asz' => TextColumn::make('gg_no_asz'),
                'gg_asz' => TextColumn::make('gg_asz'),
                'gg_cateco_no_posfun_no_asz' => TextColumn::make('gg_cateco_no_posfun_no_asz'),
                'eta' => TextColumn::make('eta'),
            ]),
            'qualifica' => QuaColumn::make('qualifica'),
            'reparto' => RepartoColumn::make('reparto'),
            'periodo' => GroupColumn::make('periodo')->schema([
                'dal' => TextColumn::make('dal'),
                'al' => TextColumn::make('al'),
                'anno' => TextColumn::make('anno'),
            ]),
        ];
    }

    /**
     * @return array<int, SelectFilter>
     */
    public function getTableFilters(): array
    {
        return [
            SelectFilter::make('anno/valutatore')
                ->label('anno/valutatore')
                ->schema([
                    Select::make('anno')
                        ->options([
                            // '2022' => '2022',
                            '2023' => '2023',
                            '2024' => '2024',
                            '2025' => '2025',
                        ])
                        ->reactive(),
                    Select::make('valutatore_id')
                        ->label('valutatore')
                        ->options(function (Get $get, Set $set): array {
                            /** @var int|string|null $anno */
                            $anno = $get('anno');

                            return app(GetValutatoriOptions::class)->execute('Progressioni', $anno);
                        }),
                    // TernaryFilter::make('ha_diritto'),
                    // *
                    Select::make('ha_diritto')->options([
                        null => '-',
                        true => 'Sì',
                        false => 'No',
                    ]),
                    // */
                    // Forms\Components\View::make('indennitacondizionilavoro::filament.tables.columns.button'),
                ])
                ->query(static function (Builder $query, array $data) {
                    if ($data['anno'] == null /* || null == $data['valutatore_id'] */) {
                        return $query->where('id', 0);
                    }

                    // unset($data['quadrimestre']);
                    if ($data['valutatore_id'] == null) {
                        unset($data['valutatore_id']);
                    }

                    if ($data['ha_diritto'] == null) {
                        unset($data['ha_diritto']);
                    }

                    $query = $query->where($data);

                    return $query;
                })->columns(4),
            // TernaryFilter::make('ha_diritto'),
        ];
    }

    /**
    * @return array<string, Action>
    */
    public function getTableActions(): array
    {
        // Types are inferred by Filament v4
        return [
            'edit' => EditAction::make()->label('')->tooltip('Modifica'),
            'view' => ViewAction::make()->label('')->tooltip('Vedi'),
            'activity-log' => ListLogActivitiesAction::make(),
        ];
    }

    public function getTableBulkActions(): array
    {
        // Types are inferred by Filament v4
        return [
            // Tables\Actions\BulkActionGroup::make([
            // Tables\Actions\DeleteBulkAction::make(),
            'send-mail' => SendMailBulkAction::make('send-mail'),
            'zip-schede' => ZipSchedaBulkAction::make('zip-schede'),
            // ]),
        ];
    }
}
