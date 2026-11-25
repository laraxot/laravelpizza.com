<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Exports;

use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Jobs\CreateXlsxFile;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Collection;
use League\Csv\Reader;
use League\Csv\Statement;
use League\Csv\Writer;
use Modules\Xot\Exports\CollectionExport;
use Modules\Xot\Exports\Jobs\XotCreateXlsxFile;
use Modules\Xot\Exports\Jobs\XotExportCsv;
use Modules\Xot\Exports\Jobs\XotPrepareCsvExport;
use Modules\Xot\Exports\XotBaseExporter;
use Modules\Xot\Tests\TestCase;
use OpenSpout\Common\Entity\Cell\EmptyCell;
use OpenSpout\Common\Entity\Cell\FormulaCell;
use OpenSpout\Common\Entity\Cell\NumericCell;
use OpenSpout\Common\Entity\Cell\StringCell;
use PHPUnit\Framework\Assert;
use ReflectionMethod;

use function Safe\fopen;
use function Safe\fwrite;
use function Safe\rewind;

uses(TestCase::class);

/**
 * @param  array<string, mixed>  $filters
 * @return array<int, ExportColumn>
 */
function resolveExporterColumns(string $resourceClass, array $filters): array
{
    $method = new ReflectionMethod(XotBaseExporterStub::class, 'resolveColumns');

    /** @var array<int, ExportColumn> $columns */
    $columns = $method->invoke(null, $resourceClass, $filters);

    return $columns;
}

describe('XotBaseExporter — colonne da getXlsFields del Resource', function (): void {
    test('modifyQuery eager-load ratings, ratings.children e ratingMorphs quando esistono', function (): void {
        $model = new ExporterEagerLoadModelStub;

        $query = $model->newQuery();
        $eager = XotBaseExporterStub::modifyQuery($query)->getEagerLoads();

        Assert::assertArrayHasKey('ratings', $eager);
        Assert::assertArrayHasKey('ratings.children', $eager);
        Assert::assertArrayHasKey('ratingMorphs', $eager);
    });

    test('senza ListRecords attivo getColumns e\' una lista vuota', function (): void {
        Assert::assertSame([], XotBaseExporterStub::getColumns());
    });

    test('resource sconosciuto o senza getXlsFields non produce colonne', function (): void {
        Assert::assertSame([], resolveExporterColumns(\stdClass::class, []));
    });

    test('i nomi colonna non contengono punti: il columnMap di Filament usa data_get', function (): void {
        $columns = resolveExporterColumns(ResourceWithXlsFieldsStub::class, ['anno' => 2026]);

        $names = array_map(static fn (ExportColumn $column): string => $column->getName(), $columns);

        foreach ($names as $name) {
            Assert::assertStringNotContainsString('.', $name);
        }
    });

    test('chiave stringa = percorso, valore = label esplicita (title rating)', function (): void {
        $columns = resolveExporterColumns(ResourceWithXlsFieldsStub::class, ['anno' => 2026]);

        $labels = array_map(static fn (ExportColumn $column): ?string => $column->getLabel(), $columns);

        Assert::assertContains('Obiettivo A', $labels);
        Assert::assertNotContains('ratings_by_id.52.pivot.value', $labels);
    });

    test('le intestazioni coincidono con CollectionExport sugli stessi getXlsFields', function (): void {
        $fields = ResourceWithXlsFieldsStub::getXlsFields(['anno' => 2026]);
        /** @var Collection<int|string, mixed> $rows */
        $rows = collect([
            [
                'id' => 1,
                'matr' => 7,
                'ratings_by_id' => [
                    52 => [
                        'pivot' => [
                            'value' => 57,
                        ],
                    ],
                ],
            ],
        ]);
        $export = new CollectionExport($rows, 'xot::inesistente.fields', $fields);
        $columns = resolveExporterColumns(ResourceWithXlsFieldsStub::class, ['anno' => 2026]);
        $labels = array_map(static fn (ExportColumn $column): ?string => $column->getLabel(), $columns);

        Assert::assertSame($export->headings(), $labels);
        Assert::assertSame(['1', '7', '57'], $export->map($rows->first()));
    });
});

describe('XotBaseExporter — celle xlsx tipizzate come PhpSpreadsheet (export_xls)', function (): void {
    test('stringa numerica diventa NumericCell: intero senza frazione, float con punto o esponente', function (): void {
        $intCell = XotBaseExporterStub::xlsxCell('57');
        $floatCell = XotBaseExporterStub::xlsxCell('3.5');
        $expCell = XotBaseExporterStub::xlsxCell('1e3');
        $negCell = XotBaseExporterStub::xlsxCell('-4');

        Assert::assertInstanceOf(NumericCell::class, $intCell);
        Assert::assertSame(57, $intCell->getValue());
        Assert::assertInstanceOf(NumericCell::class, $floatCell);
        Assert::assertSame(3.5, $floatCell->getValue());
        Assert::assertInstanceOf(NumericCell::class, $expCell);
        Assert::assertSame(1000.0, $expCell->getValue());
        Assert::assertInstanceOf(NumericCell::class, $negCell);
        Assert::assertSame(-4, $negCell->getValue());
    });

    test('zero iniziale, oltre PHP_INT_MAX e testo restano StringCell come nel binder PhpSpreadsheet', function (): void {
        foreach (['007', '99999999999999999999', 'Rossi', '2026-01-01'] as $value) {
            $cell = XotBaseExporterStub::xlsxCell($value);

            Assert::assertInstanceOf(StringCell::class, $cell, $value);
            Assert::assertSame($value, $cell->getValue());
        }
    });

    test('stringa vuota e\' EmptyCell: PhpSpreadsheet non scrive la cella', function (): void {
        Assert::assertInstanceOf(EmptyCell::class, XotBaseExporterStub::xlsxCell(''));
    });

    test('prefisso = resta formula su entrambi i canali (parita\', non protezione)', function (): void {
        Assert::assertInstanceOf(FormulaCell::class, XotBaseExporterStub::xlsxCell('=1+1'));
        Assert::assertInstanceOf(StringCell::class, XotBaseExporterStub::xlsxCell('='));
    });

    test('intestazione e righe passano dalla stessa tipizzazione', function (): void {
        $exporter = new XotBaseExporterStub(app(Export::class), [], []);

        $header = $exporter->makeXlsxHeaderRow(['id', '2024']);
        $row = $exporter->makeXlsxRow(['57', 'Rossi', '']);

        Assert::assertInstanceOf(StringCell::class, $header->getCells()[0]);
        Assert::assertInstanceOf(NumericCell::class, $header->getCells()[1]);
        Assert::assertInstanceOf(NumericCell::class, $row->getCells()[0]);
        Assert::assertInstanceOf(StringCell::class, $row->getCells()[1]);
        Assert::assertInstanceOf(EmptyCell::class, $row->getCells()[2]);
    });
});

describe('XotBaseExporter — review 5.165: overflow, testo lungo, UTF-8, CRLF', function (): void {
    test('intero oltre int64 e\' float come 0 + $value in PhpSpreadsheet, non saturato a PHP_INT_MAX', function (): void {
        $over = XotBaseExporterStub::xlsxCell('9223372036854775808');
        $negOver = XotBaseExporterStub::xlsxCell('-99999999999999999999');

        Assert::assertInstanceOf(NumericCell::class, $over);
        Assert::assertSame(0 + '9223372036854775808', $over->getValue());
        Assert::assertInstanceOf(NumericCell::class, $negOver);
        Assert::assertSame(-1.0E+20, $negOver->getValue());
    });

    test('testo oltre 32767 caratteri troncato come DataType::checkString (OpenSpout lancerebbe)', function (): void {
        $cell = XotBaseExporterStub::xlsxCell(str_repeat('x', 32768));

        Assert::assertInstanceOf(StringCell::class, $cell);
        Assert::assertSame(32767, mb_strlen($cell->getValue()));
    });

    test('CRLF e CR normalizzati a LF, byte UTF-8 invalidi sostituiti come DefaultValueBinder', function (): void {
        Assert::assertSame("a\nb\nc", XotBaseExporterStub::xlsxCell("a\r\nb\rc")->getValue());
        Assert::assertSame("caff\u{FFFD}", XotBaseExporterStub::xlsxCell("caff\xE8")->getValue());
    });
});

describe('XotBaseExporter — CSV intermedio con escape CSV_ESCAPE (round-trip intatto)', function (): void {
    /**
     * @param  list<list<string>>  $rows
     * @return list<list<string>>
     */
    function csvRoundTrip(array $rows): array
    {
        $writer = Writer::from(new \SplTempFileObject);
        $writer->setEscape(XotBaseExporter::CSV_ESCAPE);
        foreach ($rows as $row) {
            $writer->insertOne($row);
        }

        $stream = fopen('php://temp', 'r+');
        fwrite($stream, $writer->toString());
        rewind($stream);

        $reader = Reader::from($stream);
        $reader->setEscape(XotBaseExporter::CSV_ESCAPE);
        $reader->includeEmptyRecords();

        /** @var list<list<string>> $out */
        $out = iterator_to_array((new Statement)->process($reader)->getRecords(), false);

        return $out;
    }

    test('valore che finisce con backslash non inghiotte la riga successiva', function (): void {
        Assert::assertSame([['a\\', 'x'], ['c', 'd']], csvRoundTrip([['a\\', 'x'], ['c', 'd']]));
        Assert::assertSame([['C:\\dir\\'], ['next']], csvRoundTrip([['C:\\dir\\'], ['next']]));
    });

    test('backslash + virgolette, virgolette, delimitatore e newline restano intatti', function (): void {
        $rows = [['a\\"b', 'x'], ['"q"', 'a,b'], ["l1\nl2", "l1\r\nl2"]];

        Assert::assertSame($rows, csvRoundTrip($rows));
    });

    test('XotBaseExportAction usa XotPrepareCsvExport, che sceglie XotExportCsv', function (): void {
        Assert::assertSame(XotPrepareCsvExport::class, ExportActionStub::make('export')->getJob());

        $job = new ReflectionMethod(XotPrepareCsvExport::class, 'getExportCsvJob');
        Assert::assertSame(XotExportCsv::class, $job->invoke($job->getDeclaringClass()->newInstanceWithoutConstructor()));
    });

    test('il container risolve CreateXlsxFile in XotCreateXlsxFile (binding XotServiceProvider)', function (): void {
        $export = app(Export::class);
        $export->exporter = XotBaseExporterStub::class;

        $job = app(CreateXlsxFile::class, [
            'export' => $export,
            'columnMap' => [],
            'options' => [],
        ]);

        Assert::assertInstanceOf(XotCreateXlsxFile::class, $job);
    });
});
