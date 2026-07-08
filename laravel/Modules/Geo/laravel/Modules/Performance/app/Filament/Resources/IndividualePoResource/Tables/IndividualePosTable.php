<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\IndividualePoResource\Tables;

use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Modules\Performance\Actions\ShowMailSendedAt;
use Modules\Performance\Filament\Resources\IndividualePoResource;
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

class IndividualePosTable extends XotBaseResourceTable
{
    /**
     * @return array<string, mixed>
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
                ->visible(fn () => ! in_array(HasParent::class, class_uses_recursive(IndividualePoResource::getModel()))),

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
     * @return array<string, mixed>
     */
    public function getTableFilters(): array
    {
        return [
            'anno_valutatore' => AnnoValutatoreFilter::make('anno_valutatore'),
            'ha_diritto' => TernaryFilter::make('ha_diritto'),
            'type' => SelectFilter::make('type')
                ->options(WorkerType::class)
                ->visible(fn () => ! in_array(HasParent::class, class_uses_recursive(IndividualePoResource::getModel()))),

        ];
    }

    /**
     * @return array<int|string, \Filament\Actions\Action|\Filament\Actions\ActionGroup>
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
     * @return array<string, mixed>
     */
    public function getTableBulkActions(): array
    {
        return [
            'send_mail' => SendMailBulkAction::make('send_mail'),
            'zip_schede' => ZipSchedaBulkAction::make('zip_schede'),
        ];
    }
}
