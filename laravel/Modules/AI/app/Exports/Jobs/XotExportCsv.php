<?php

declare(strict_types=1);

namespace Modules\Xot\Exports\Jobs;

use AnourValar\EloquentSerialize\Facades\EloquentSerializeFacade;
use Filament\Actions\Exports\Jobs\ExportCsv;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Database\Query\Expression;
use Illuminate\Support\Facades\DB;
use League\Csv\Writer;
use Modules\Xot\Exports\XotBaseExporter;
use SplTempFileObject;
use Throwable;

/**
 * `ExportCsv` con il CSV intermedio in escape `XotBaseExporter::CSV_ESCAPE`.
 *
 * `handle()` e' la copia di filament/actions 5.7.8 con una sola riga in piu'
 * (`setEscape`): il Writer nasce dentro il metodo e il vendor non offre hook.
 * Selezionato da `XotPrepareCsvExport::getExportCsvJob()`.
 */
class XotExportCsv extends ExportCsv
{
    #[\Override]
    public function handle(): void
    {
        if ($this->batch()?->cancelled()) {
            return;
        }

        /** @var Authenticatable $user */
        $user = $this->export->user;

        auth()->setUser($user);

        try {
            $processedRows = 0;
            $successfulRows = 0;

            $csv = Writer::from(new SplTempFileObject);
            $csv->setDelimiter($this->exporter::getCsvDelimiter());
            $csv->setEscape(XotBaseExporter::CSV_ESCAPE);

            $query = EloquentSerializeFacade::unserialize($this->query);

            foreach ($this->exporter->getCachedColumns() as $column) {
                $column->applyRelationshipAggregates($query);
                $column->applyEagerLoading($query);
            }

            foreach ($query->find($this->records) as $record) {
                try {
                    $csv->insertOne(($this->exporter)($record));

                    $successfulRows++;
                } catch (Throwable $exception) {
                    report($exception);
                }

                $processedRows++;
            }

            $filePath = $this->export->getFileDirectory().DIRECTORY_SEPARATOR.str_pad((string) $this->page, 16, '0', STR_PAD_LEFT).'.csv';

            DB::transaction(function () use ($csv, $filePath, $processedRows, $successfulRows): void {
                // `incrementEach` = `SET processed_rows = processed_rows + N` del vendor
                // (che usa `new Expression('processed_rows + '.$n)`, stringa non literal).
                $this->export::query()
                    ->whereKey($this->export->getKey())
                    ->lockForUpdate()
                    ->incrementEach([
                        'processed_rows' => $processedRows,
                        'successful_rows' => $successfulRows,
                    ]);

                $this->export::query()
                    ->whereKey($this->export->getKey())
                    ->whereColumn('processed_rows', '>', 'total_rows')
                    ->lockForUpdate()
                    ->update([
                        'processed_rows' => new Expression('total_rows'),
                    ]);

                $this->export::query()
                    ->whereKey($this->export->getKey())
                    ->whereColumn('successful_rows', '>', 'total_rows')
                    ->lockForUpdate()
                    ->update([
                        'successful_rows' => new Expression('total_rows'),
                    ]);

                $this->export->getFileDisk()->put($filePath, $csv->toString(), Filesystem::VISIBILITY_PRIVATE);
            });
        } finally {
            auth()->forgetGuards();
        }
    }
}
