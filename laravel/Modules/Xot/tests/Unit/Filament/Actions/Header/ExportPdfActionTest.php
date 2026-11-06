<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Filament\Actions\Header;

use Modules\Xot\Filament\Actions\Header\ExportPdfAction;
use Modules\Xot\Filament\Actions\XotBaseAction;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('ExportPdfAction — PDF header UX', function (): void {
    test('nome export_pdf, icona xot-files.pdf, solo icona', function (): void {
        Assert::assertSame('export_pdf', ExportPdfAction::getDefaultName());
        Assert::assertSame(XotBaseAction::class, get_parent_class(ExportPdfAction::class));

        $action = ExportPdfAction::make('export_pdf');

        Assert::assertSame('xot-files.pdf', $action->getIcon());
        Assert::assertTrue($action->isIconButton());
        Assert::assertSame('', $action->getLabel());
        Assert::assertFileExists(module_path('Xot', 'resources/svg/files/pdf.svg'));
    });
});
