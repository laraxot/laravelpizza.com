<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Filament\Actions\Header;

use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Actions\Exports\Models\Export;
use Modules\Xot\Exports\Jobs\XotPrepareCsvExport;
use Modules\Xot\Exports\XlsFieldsExporter;
use Modules\Xot\Exports\XotBaseExporter;
use Modules\Xot\Filament\Actions\Header\ExportXlsxAction;
use Modules\Xot\Filament\Actions\XotBaseExportAction;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('ExportXlsxAction — export nativo generico su getXlsFields', function (): void {
    test('estende XotBaseExportAction, nome export_xlsx, exporter generico XlsFieldsExporter', function (): void {
        Assert::assertSame('export_xlsx', ExportXlsxAction::getDefaultName());
        Assert::assertSame(XotBaseExportAction::class, get_parent_class(ExportXlsxAction::class));

        $action = ExportXlsxAction::make('export_xlsx');

        Assert::assertSame(XlsFieldsExporter::class, $action->getExporter());
        Assert::assertSame(XotBaseExporter::class, get_parent_class(XlsFieldsExporter::class));
    });

    test('tutte le colonne, solo xlsx, nessun modal, job Xot con CSV senza escape', function (): void {
        $action = ExportXlsxAction::make('export_xlsx');

        Assert::assertFalse($action->hasColumnMapping());
        Assert::assertSame([ExportFormat::Xlsx], $action->getFormats());
        Assert::assertFalse($action->hasModal());
        Assert::assertSame(XotPrepareCsvExport::class, $action->getJob());
    });

    test('icona custom xot-files.xlsx (SVG griglia, non heroicon generico)', function (): void {
        $action = ExportXlsxAction::make('export_xlsx');

        Assert::assertSame('xot-files.xlsx', $action->getIcon());
        Assert::assertFileExists(module_path('Xot', 'resources/svg/files/xlsx.svg'));
    });

    test('un modulo puo\' passare il proprio exporter', function (): void {
        $action = ExportXlsxAction::make('export_xlsx')->exporter(ExporterStub::class);

        Assert::assertSame(ExporterStub::class, $action->getExporter());
    });

    test('notifica di fine export tradotta con conteggio righe e fallite', function (): void {
        $export = app(Export::class);
        $export->exporter = XlsFieldsExporter::class;
        $export->total_rows = 3;
        $export->successful_rows = 2;

        $body = XlsFieldsExporter::getCompletedNotificationBody($export);

        Assert::assertStringContainsString('2', $body);
        Assert::assertStringContainsString('1', $body);
        Assert::assertStringNotContainsString('xot::export', $body);
    });
});
