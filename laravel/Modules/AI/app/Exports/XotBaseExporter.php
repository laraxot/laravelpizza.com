<?php

declare(strict_types=1);

namespace Modules\Xot\Exports;

use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Modules\Lang\Actions\TransArrayAction;
use Modules\Xot\Actions\GetTransKeyAction;
use OpenSpout\Common\Entity\Cell;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Common\Entity\Style\Style;

/**
 * Exporter Filament 5 che riusa il contratto `getXlsFields()` dei Resource.
 *
 * Stesso formato misto di `CollectionExport`: chiave intera => percorso `data_get`
 * (label = traduzione via `transKey`), chiave stringa => percorso con valore =
 * intestazione esplicita non tradotta (es. `title` del rating).
 *
 * Percorso dei filtri:
 * - al dispatch `getColumns()` (statico) legge `tableFilters` dal componente
 *   Livewire corrente (`app('livewire')->current()`);
 * - nel job di export `getCachedColumns()` (istanza) legge gli stessi filtri da
 *   `$options['tableFilters']`, serializzati da `XotBaseExportAction` — il job
 *   non ha un componente Livewire attivo.
 *
 * I nomi colonna non possono contenere `.` (romperebbe il `columnMap` via
 * `data_get` in `CanExportRecords`): i punti del percorso diventano `_` e lo
 * stato viene risolto con `data_get($record, $percorso)`.
 *
 * Tipo delle celle: il job nativo passa dal CSV (`ExportCsv` → `CreateXlsxFile`),
 * quindi OpenSpout riceve solo stringhe e `"57"` diventerebbe testo. `export_xls`
 * (PhpSpreadsheet, `DefaultValueBinder`) lo scrive come numero: `makeXlsxRow()`
 * applica lo stesso binder, cosi' i due file hanno gli stessi tipi di cella.
 *
 * Eager load: `ratings_by_id` (HasRatingsTrait) legge `ratings` + `ratingMorphs`;
 * `xls_export_value` risolve anche `ratings.children` (padre Select → txt figlio).
 * `modifyQuery()` li carica se il model li ha, altrimenti il job chunked farebbe
 * N query per riga. Stessa regola in `ExportXlsAction` (che la chiama).
 *
 * CSV intermedio: i job Filament usano League\Csv con escape `\` (default PHP):
 * un valore che finisce con `\` chiude il campo con `\"` e il reader lo legge
 * come virgolette escapate, inghiottendo il resto della riga e le righe dopo.
 * I job Xot (`Jobs\XotPrepareCsvExport`, `Jobs\XotExportCsv`, `Jobs\XotCreateXlsxFile`)
 * scrivono e leggono con `CSV_ESCAPE` (nessun escape, RFC 4180): round-trip
 * intatto anche per `a\` e `a\"b`.
 */
abstract class XotBaseExporter extends Exporter
{
    /**
     * Escape del CSV intermedio (writer e reader devono coincidere).
     */
    public const string CSV_ESCAPE = '';

    /**
     * Relation caricate se esistono sul model: `ratings_by_id` le legge entrambe.
     *
     * @template TModel of Model
     *
     * @param  Builder<TModel>  $query
     * @return Builder<TModel>
     */
    #[\Override]
    public static function modifyQuery(Builder $query): Builder
    {
        $model = $query->getModel();
        $with = [];
        if (method_exists($model, 'ratings')) {
            $with[] = 'ratings';
            $with[] = 'ratings.children';
        }
        if (method_exists($model, 'ratingMorphs')) {
            $with[] = 'ratingMorphs';
        }

        return $with === [] ? $query : $query->with($with);
    }

    /**
     * Corpo della notifica di fine export, tradotto (`xot::export.notifications.completed`).
     * Story Ptv/5.160: niente stringhe hardcoded negli exporter dei moduli.
     */
    #[\Override]
    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = trans_choice('xot::export.notifications.completed.body', $export->successful_rows, [
            'count' => number_format($export->successful_rows),
        ]);

        $failedRowsCount = $export->getFailedRowsCount();
        if ($failedRowsCount > 0) {
            $body .= ' '.trans_choice('xot::export.notifications.completed.failed', $failedRowsCount, [
                'count' => number_format($failedRowsCount),
            ]);
        }

        return $body;
    }

    /**
     * Righe (e intestazione: `makeXlsxHeaderRow` delega qui) con le celle
     * tipizzate come PhpSpreadsheet in `export_xls`. Story Ptv/5.165.
     *
     * @param  array<mixed>  $values
     */
    #[\Override]
    public function makeXlsxRow(array $values, ?Style $style = null): Row
    {
        $cells = [];
        foreach ($values as $value) {
            $cells[] = static::xlsxCell($value, $style);
        }

        return new Row($cells, $style);
    }

    /**
     * Stessa cella che PhpSpreadsheet darebbe alla stessa stringa: {@see XlsxCellFactory}.
     */
    public static function xlsxCell(mixed $value, ?Style $style = null): Cell
    {
        return XlsxCellFactory::make($value, $style);
    }

    /**
     * @return array<int, ExportColumn>
     */
    #[\Override]
    public static function getColumns(): array
    {
        $livewire = app('livewire')->current();

        if (! $livewire instanceof ListRecords) {
            return [];
        }

        return static::resolveColumns(
            $livewire->getResource(),
            $livewire->tableFilters ?? [],
            $livewire::class,
        );
    }

    /**
     * Nel job: ricostruisce le colonne dagli `options` serializzati.
     *
     * @return array<ExportColumn>
     */
    #[\Override]
    public function getCachedColumns(): array
    {
        if (! isset($this->cachedColumns)) {
            $resource = Arr::get($this->options, 'resource');
            $resource = \is_string($resource) && class_exists($resource) ? $resource : null;
            $filters = Arr::get($this->options, 'tableFilters', []);
            $transClass = Arr::get($this->options, 'livewireClass');
            $transClass = \is_string($transClass) && class_exists($transClass) ? $transClass : $resource;
            /** @var array<string, mixed> $filters */
            $this->cachedColumns = [];
            foreach (static::resolveColumns($resource, \is_array($filters) ? $filters : [], $transClass) as $column) {
                $this->cachedColumns[$column->getName()] = $column->exporter($this);
            }
        }

        return $this->cachedColumns;
    }

    /**
     * @param  class-string|null  $resource
     * @param  array<array-key, mixed>  $filters
     * @param  class-string|null  $transClass  come ExportXlsAction: classe Livewire/page, non il Resource
     * @return array<int, ExportColumn>
     */
    protected static function resolveColumns(?string $resource, array $filters, ?string $transClass = null): array
    {
        if ($resource === null || ! method_exists($resource, 'getXlsFields')) {
            return [];
        }

        /** @var array<int|string, string> $fields */
        $fields = $resource::getXlsFields($filters);

        $transKey = app(GetTransKeyAction::class)->execute($transClass ?? $resource).'.fields';

        $columns = [];
        foreach ($fields as $key => $value) {
            $path = \is_string($key) ? $key : $value;
            $label = \is_string($key)
                ? $value
                : (array_values(app(TransArrayAction::class)->execute([$path], $transKey))[0] ?? $path);

            $columns[] = ExportColumn::make(static::columnName($path))
                ->label($label)
                ->state(static fn (Model $record): string => CollectionExport::castCell(data_get($record, $path)));
        }

        return $columns;
    }

    /**
     * Il modello arriva dal Resource della pagina corrente, non da `static::$model`:
     * lo stesso exporter serve tutte le liste scheda (Dip/Po/Dirigente/...).
     *
     * @return class-string<Model>
     */
    #[\Override]
    public static function getModel(): string
    {
        $livewire = app('livewire')->current();

        if ($livewire instanceof ListRecords) {
            /** @var class-string<Model> */
            return $livewire->getResource()::getModel();
        }

        /** @var class-string<Model> */
        return parent::getModel();
    }

    /**
     * `data_get` sul columnMap usa `.` come separatore: il nome colonna non puo'
     * contenerlo. Il percorso reale resta nella closure `state`.
     */
    protected static function columnName(string $path): string
    {
        return (string) Str::of($path)->replace('.', '_');
    }
}
