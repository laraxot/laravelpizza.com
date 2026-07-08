<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources\IndennitaResponsabilitaResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkAction;
use Filament\Pages\Actions\CreateAction;
use Filament\Tables;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\TernaryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Modules\Activity\Filament\Actions\ListLogActivitiesAction;
use Modules\IndennitaResponsabilita\Actions\MakePdf;
use Modules\IndennitaResponsabilita\Actions\MakePdfByRecord;
use Modules\IndennitaResponsabilita\Filament\Exports\IndennitaResponsabilitaExporter;
use Modules\IndennitaResponsabilita\Filament\Resources\IndennitaResponsabilitaResource;
use Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita;
use Modules\IndennitaResponsabilita\Models\Rating;
use Modules\Ptv\Actions\Scheda\GetSentEmailListHtml;
use Modules\Ptv\Filament\Actions\Bulk\SendSchedaBulkAction;
use Modules\Ptv\Filament\Actions\Bulk\ZipSchedaBulkAction;
use Modules\Ptv\Filament\Actions\Header\DeleteCessatiAction;
use Modules\Ptv\Filament\Actions\Scheda\CompilaAction;
use Modules\Ptv\Filament\Actions\Table\RecordPdfAction;
use Modules\Ptv\Filament\Filters\AnnoValutatoreFilter;
use Modules\Ptv\Filament\Tables\Columns\PeriodoColumn;
use Modules\Ptv\Filament\Tables\Columns\RepColumn;
use Modules\Ptv\Filament\Tables\Columns\WorkerColumn;
use Modules\Xot\Filament\Actions\Header\ExportPdfAction;
use Modules\Xot\Filament\Actions\Header\ExportXlsAction;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Override;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ListIndennitaResponsabilitas extends XotBaseListRecords
{
    protected static string $resource = IndennitaResponsabilitaResource::class;

    /**
     * @return array<string, Action>
     */
    #[Override]
    protected function getHeaderActions(): array
    {
        // dddx($this->getTableQuery());
        /** @var array<string, string|int|bool|null>|null $tableFilters */
        $tableFilters = $this->tableFilters;
        /** @var array<string, string|int|bool|null> $filtersForPdf */
        $filtersForPdf = $tableFilters ?? [];
        /** @var array<string, string|int|bool|null>|null $filtersForUrl */
        $filtersForUrl = $this->tableFilters;

        return [
            /*
            'exportPdf' => Action::make('exportPdf')
                ->icon('heroicon-s-document')
                ->action(function (): BinaryFileResponse {
                    // @var array<string, mixed> $tableFilters 
                    $tableFilters = $this->tableFilters ?? [];

                    return app(MakePdf::class)->execute($tableFilters);
                }),
            */
            'SendMail' => Action::make('SendMail')
                ->icon('heroicon-o-paper-airplane')
                ->url(fn () => IndennitaResponsabilitaResource::getUrl('send-mail', $filtersForUrl ?? []))
                ->visible(false),
            'DeleteCessatiAction' => DeleteCessatiAction::make(),

            // CreateAction::make(),
            /*
            Actions\ExportAction::make()
               ->exporter(IndennitaResponsabilitaExporter::class)
               ->tooltip('esporta xls')
               ->icon('fas-file-excel')
               ->modifyQueryUsing(function ($query) {
                   return $this->getTableQuery();
               }),
            */
            'exportXls' => ExportXlsAction::make('exportXls'),
            // ->exportOnlyFiltered(),
            'exportPdf1' => ExportPdfAction::make('exportPdf1'),
        ];
    }

    /**
     * @return array<int|string, Column>
     */
    #[Override]
    public function getTableColumns(): array
    {
        // Column types are inferred by Filament v4
        return [
            'lavoratore' => WorkerColumn::make('lavoratore'),
            // RepColumn::make('rep'),
            // 'anno' => TextColumn::make('anno')->sortable()->searchable(),
            'periodo' => PeriodoColumn::make('periodo'),
            // 'sent_email_list' => TextColumn::make('sent_email_list')->html()->default(app(GetSentEmailListHtml::class)->execute(...)),
        ];
    }

    /**
     * @return array<string, BulkAction>
     */
    #[Override]
    public function getTableBulkActions(): array
    {
        // dddx($this->tableFilters);
        /** @var array<string, mixed> $tableFilters */
        $tableFilters = $this->tableFilters ?? [];

        /** @var array<string, mixed> $annoValutatoreFilter */
        $annoValutatoreFilter = Arr::get($tableFilters, 'anno/valutatore', []);
        /** @var int|string|null $anno */
        $anno = Arr::get($annoValutatoreFilter, 'anno');

        /** @var non-falsy-string $tpl */
        $tpl = 'indennitaresponsabilita-'.(string) ($anno ?? '');

        return [
            'zip-schede' => ZipSchedaBulkAction::make('zip-schede'),
            'send-mail' => SendSchedaBulkAction::make('send-mail')->setTemplate($tpl),

        ];
    }

    /**
     * @return array<int|string, Action|ActionGroup>
     */
    #[Override]
    public function getTableActions(): array
    {
        return [
            // Tables\Actions\ViewAction::make(),
            ...parent::getTableActions(),
            'compila' => CompilaAction::make(),
            'record-pdf1' => RecordPdfAction::make('record-pdf1')->visible(fn ($record): bool => Gate::allows('record-pdf', $record)),
            /*
            'record-pdf' => Action::make('record-pdf')
                ->icon('heroicon-o-document')
                // ->url( fn ($record): string => IndennitaResponsabilitaResource::getUrl('pdf', ['record' => $record])),
                ->action(app(MakePdfByRecord::class)->execute(...))
                ->visible(function ($record): bool {
                    // @var IndennitaResponsabilita $record
                    // @var \Illuminate\Database\Eloquent\Collection<int, Rating>|null $ratings
                    $ratings = $record->ratings;
                    if (null === $ratings) {
                        return false;
                    }
                    // @var float|int $sum
                    $sum = $ratings->sum('pivot.value');

                    return $sum > 0;
                }),
            */

            // Tables\Actions\EditAction::make(),
            // Action::make('activities')->url(fn ($record) => IndennitaResponsabilitaResource::getUrl('log-activity', ['record' => $record]))
            // 'log-activity' => ListLogActivitiesAction::make(), // Temporarily disabled - route registration issue
        ];
    }

    /*
    protected function getTableFiltersLayout(): ?string
    {
        return FiltersLayout::AboveContent;
    }

    protected function getTableFiltersFormColumns(): int
    {
        return 1;
    }

    protected function getTableFiltersFormWidth(): string
    {
        return '4xl';
    }

    protected function shouldPersistTableFiltersInSession(): bool
    {
        return true;
    }
    */
    public function getTableFilters(): array
    {
        return [
            'anno_valutatore' => AnnoValutatoreFilter::make('anno_valutatore')
                ->columns(2),
            'is_compiled' => TernaryFilter::make('is_compiled')
                ->columns(2)
                ->queries(
                    true: function (Builder $query): Builder {
                        /** @var Builder<IndennitaResponsabilita> $query */
                        /** @var Builder<IndennitaResponsabilita> $result */
                        $result = $query->isCompiled();

                        return $result;
                    },
                    false: function (Builder $query): Builder {
                        /** @var Builder<IndennitaResponsabilita> $query */
                        /** @var Builder<IndennitaResponsabilita> $result */
                        $result = $query->isNotCompiled();

                        return $result;
                    },
                    blank: fn (Builder $query): Builder => $query, // In this example, we do not want to filter the query when it is blank.
                ),
        ];
    }

    #[Override]
    public function getTableFiltersFormColumns(): int
    {
        return 2;
    }
}
