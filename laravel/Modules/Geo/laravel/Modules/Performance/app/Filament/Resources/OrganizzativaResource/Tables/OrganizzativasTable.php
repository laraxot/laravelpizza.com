<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\OrganizzativaResource\Tables;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkAction;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\BaseFilter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Modules\Performance\Actions\ShowMailSendedAt;
use Modules\Performance\Filament\Actions\Header\CopyFromIndividualeAction;
use Modules\Performance\Filament\Actions\Header\CopyValutatoreIdFromIndividualeAction;
use Modules\Performance\Filament\Resources\OrganizzativaResource;
use Modules\Performance\Models\StabiDirigente;
use Modules\Ptv\Enums\WorkerType;
use Modules\Ptv\Filament\Actions\Bulk\SendMailBulkAction;
use Modules\Ptv\Filament\Actions\Bulk\ZipSchedaBulkAction;
use Modules\Ptv\Filament\Actions\Scheda\CompilaAction;
use Modules\Ptv\Filament\Columns\LavoratoreColumn;
use Modules\Ptv\Filament\Columns\PeriodoColumn;
use Modules\Ptv\Filament\Columns\QualificaColumn;
use Modules\Ptv\Filament\Columns\RepartoColumn;
use Modules\Ptv\Filament\Filters\AnnoValutatoreFilter;
use Modules\Ptv\Models\Contracts\SchedaContract;
use Modules\UI\Filament\Tables\Columns\GroupColumn;
use Modules\Xot\Filament\Actions\Table\PdfAction;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;
use Parental\HasParent;

class OrganizzativasTable extends XotBaseResourceTable
{
    /**
     * @return array<int|string, Action|ActionGroup>
     */
    public function getTableHeaderActions(): array
    {
        return [
            ...parent::getTableHeaderActions(),
            'copy_valutatore_id_from_individuale' => CopyValutatoreIdFromIndividualeAction::make('copy_valutatore_id_from_individuale'),
            'copy_from_individuale' => CopyFromIndividualeAction::make('copy_from_individuale'),
        ];
    }

    /**
     *  array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'id/motivo' => GroupColumn::make('id/motivo')->schema([
                'id' => TextColumn::make('id'),
                // 'type' => TextColumn::make('type'),
                // 'ha_diritto' => IconColumn::make('ha_diritto')->boolean(),
                'motivo' => TextColumn::make('motivo'),
            ])->searchable(['motivo']),
            /*
            'id'=>TextColumn::make('id'),
            */
            'type' => TextColumn::make('type')
                ->visible(fn () => ! in_array(HasParent::class, class_uses_recursive(OrganizzativaResource::getModel()))),

            'ha_diritto' => IconColumn::make('ha_diritto')->boolean(),

            'mail_sended_at' => TextColumn::make('mail_sended_at')
                ->html()
                ->default(fn (SchedaContract $record): string => app(ShowMailSendedAt::class)->execute($record)),

            /*
            'motivo_invio_email' => GroupColumn::make('motivo/invio_email')->schema([
                'motivo' => TextColumn::make('motivo')->searchable(),
                'mail_sended_at' => TextColumn::make('mail_sended_at')
                    ->html()
                    ->default(fn($record)=>app(ShowMailSendedAt::class)->execute($record)),
            ]),
            */

            'lavoratore' => LavoratoreColumn::make('lavoratore')->appendColumns([
                // 'totale_punteggio' => TextColumn::make('totale_punteggio'),
                // 'propro' => TextColumn::make('propro'),
            ]),

            'qualifica' => QualificaColumn::make('qualifica'),
            'reparto' => RepartoColumn::make('reparto'),
            'periodo' => PeriodoColumn::make('periodo'),

            'valutatore_id' => SelectColumn::make('valutatore_id')
                ->label('valutatore')
                ->options(function (mixed $record): array {
                    if (! is_object($record) || ! isset($record->anno)) {
                        return [];
                    }
                    // @var int $anno
                    $anno = $record->anno;

                    return StabiDirigente::where('anno', $anno)->whereRaw('id=valutatore_id')->pluck('nome_diri', 'id')->toArray();
                })
                ->visible(auth()->user()?->isSuperAdmin() ?? false),

        ];
    }

    /**
     * @return array<string, \Filament\Tables\Filters\BaseFilter>
     */
    public function getTableFilters(): array
    {
        return [
            'anno_valutatore' => AnnoValutatoreFilter::make('anno_valutatore'),
            'ha_diritto' => TernaryFilter::make('ha_diritto'),
            'type' => SelectFilter::make('type')
                ->options(WorkerType::class)
                ->visible(fn () => ! in_array(HasParent::class, class_uses_recursive(OrganizzativaResource::getModel()))),

        ];
    }

    /**
     *  array<string, Action|ActionGroup>
     */
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

    /**
     *  array<string, BulkAction>
     */
    public function getTableBulkActions(): array
    {
        return [
            'send_mail' => SendMailBulkAction::make('send_mail'),
            'zip_schede' => ZipSchedaBulkAction::make('zip_schede'),
        ];
    }
}
