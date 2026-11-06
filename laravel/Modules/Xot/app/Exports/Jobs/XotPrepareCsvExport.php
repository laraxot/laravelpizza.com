<?php

declare(strict_types=1);

namespace Modules\Xot\Exports\Jobs;

use Filament\Actions\Exports\Jobs\PrepareCsvExport;
use Illuminate\Contracts\Filesystem\Filesystem;
use League\Csv\Bom;
use League\Csv\Writer;
use Modules\Xot\Exports\XotBaseExporter;
use SplTempFileObject;

/**
 * `PrepareCsvExport` con il CSV intermedio in escape `XotBaseExporter::CSV_ESCAPE`.
 *
 * Il job vendor scrive `headers.csv` con League\Csv (escape `\`) e sceglie
 * `ExportCsv` per i chunk: qui i chunk vanno a `XotExportCsv` e l'header viene
 * riscritto con lo stesso escape dopo `parent::handle()` (che lo ha gia'
 * scritto; `CreateXlsxFile` lo legge solo nel job successivo della chain).
 * Montato da `XotBaseExportAction::setUp()` via `->job()`.
 */
class XotPrepareCsvExport extends PrepareCsvExport
{
    #[\Override]
    public function handle(): void
    {
        parent::handle();

        $csv = Writer::from(new SplTempFileObject);
        $csv->setOutputBOM(Bom::Utf8);
        $csv->setDelimiter($this->exporter::getCsvDelimiter());
        $csv->setEscape(XotBaseExporter::CSV_ESCAPE);
        $csv->insertOne(array_values($this->columnMap));

        $filePath = $this->export->getFileDirectory().DIRECTORY_SEPARATOR.'headers.csv';
        $this->export->getFileDisk()->put($filePath, $csv->toString(), Filesystem::VISIBILITY_PRIVATE);
    }

    #[\Override]
    public function getExportCsvJob(): string
    {
        return XotExportCsv::class;
    }
}
