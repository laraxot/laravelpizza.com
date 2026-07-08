<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources\SchedaResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkAction;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Widgets\WidgetConfiguration;
use Illuminate\Support\Arr;
use Modules\Performance\Actions\ShowMailSendedAt;
use Modules\Performance\Models\StabiDirigente;
use Modules\Ptv\Enums\WorkerType;
use Modules\Ptv\Filament\Actions\Bulk\SendMailBulkAction;
use Modules\Ptv\Filament\Actions\Bulk\ZipSchedaBulkAction;
use Modules\Ptv\Filament\Actions\Header\CopyFromLastYearAction;
use Modules\Ptv\Filament\Actions\Header\PopulateYearAction;
use Modules\Ptv\Filament\Actions\Header\TrovaEsclusiAction;
use Modules\Ptv\Filament\Actions\Scheda\CompilaAction;
use Modules\Ptv\Filament\Columns\LavoratoreColumn;
use Modules\Ptv\Filament\Columns\PeriodoColumn;
use Modules\Ptv\Filament\Columns\QualificaColumn;
use Modules\Ptv\Filament\Columns\RepartoColumn;
use Modules\Ptv\Filament\Filters\AnnoValutatoreFilter;
use Modules\Ptv\Filament\Resources\ReportResource\Widgets\FirmaValutatoreWidget;
use Modules\Ptv\Models\Contracts\SchedaContract;
use Modules\UI\Filament\Tables\Columns\GroupColumn;
use Modules\Xot\Filament\Actions\Header\ExportPdfAction;
use Modules\Xot\Filament\Actions\Header\ExportXlsAction;
use Modules\Xot\Filament\Actions\Table\PdfAction;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Override;
use Parental\HasParent;

/**
 * Lista schede condivisa tra moduli Ptv/Performance/Progressioni.
 *
 * Le classi concrete impostano `$resource` sulla propria Resource.
 */
abstract class BaseListSchedas extends XotBaseListRecords
{
    #[Override]
    protected function getHeaderActions(): array
    {
        return [
            ...parent::getHeaderActions(),
            'copy_from_last_year' => CopyFromLastYearAction::make(),
            'populate_year' => PopulateYearAction::make(),
            'trova_esclusi' => TrovaEsclusiAction::make(),
            'export_xls' => ExportXlsAction::make(),
            'export_pdf' => ExportPdfAction::make('export_pdf'),
        ];
    }

    /**
     * @return array<string, Column>
     */
    #[Override]
    public function getTableColumns(): array
    {
        return [
            'id/motivo' => GroupColumn::make('id/motivo')->schema([
                'id' => TextColumn::make('id'),
                'motivo' => TextColumn::make('motivo'),
            ])->searchable(['motivo']),
            'type' => TextColumn::make('type')
                ->visible(fn (): bool => ! in_array(HasParent::class, class_uses_recursive(static::getModel()), true)),
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

                    /** @var int $anno */
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

    #[Override]
    public function getTableFilters(): array
    {
        return [
            'anno_valutatore' => AnnoValutatoreFilter::make('anno_valutatore'),
            'ha_diritto' => TernaryFilter::make('ha_diritto'),
            'type' => SelectFilter::make('type')
                ->options(WorkerType::class)
                ->visible(fn (): bool => ! in_array(HasParent::class, class_uses_recursive(static::getModel()), true)),
        ];
    }

    /**
     * @return array<int|string, Action|ActionGroup>
     */
    #[Override]
    public function getTableActions(): array
    {
        return [
            ...parent::getTableActions(),
            'compila' => CompilaAction::make()
                ->visible(fn (SchedaContract $record): bool => (int) $record->ha_diritto > 0),
            'pdf' => PdfAction::make('pdf')
                ->visible(fn (SchedaContract $record): bool => (int) $record->ha_diritto > 0),
        ];
    }

    /**
     * @return array<string, BulkAction>
     */
    #[Override]
    public function getTableBulkActions(): array
    {
        return [
            'send_mail' => SendMailBulkAction::make('send_mail'),
            'zip_schede' => ZipSchedaBulkAction::make('zip_schede'),
        ];
    }

    /**
     * @return array<string, WidgetConfiguration>
     */
    public function getHeaderWidgets(): array
    {
        $filters = Arr::get($this->tableFilters ?? [], 'anno_valutatore');

        return [
            'firma_valutatore' => FirmaValutatoreWidget::make(['resource' => static::$resource, 'filters' => $filters]),
        ];
    }
}
