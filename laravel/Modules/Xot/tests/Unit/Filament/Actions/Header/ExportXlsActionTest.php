<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Filament\Actions\Header;

use Modules\Xot\Filament\Actions\Header\ExportXlsAction;
use Modules\Xot\Filament\Actions\Header\ExportXlsLazyAction;
use Modules\Xot\Filament\Actions\XotBaseAction;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('ExportXlsAction — XLS header UX', function (): void {
    test('nome export_xls, icona xot-files.xls, solo icona', function (): void {
        Assert::assertSame('export_xls', ExportXlsAction::getDefaultName());
        Assert::assertSame(XotBaseAction::class, get_parent_class(ExportXlsAction::class));

        $action = ExportXlsAction::make('export_xls');

        Assert::assertSame('xot-files.xls', $action->getIcon());
        Assert::assertTrue($action->isIconButton());
        Assert::assertSame('', $action->getLabel());
        Assert::assertFileExists(module_path('Xot', 'resources/svg/files/xls.svg'));
    });
});

describe('ExportXlsLazyAction — stessa icona xot-files.xls', function (): void {
    test('nome export_xls, icona xot-files.xls, solo icona (non chiave lang rotta)', function (): void {
        Assert::assertSame('export_xls', ExportXlsLazyAction::getDefaultName());
        Assert::assertSame(XotBaseAction::class, get_parent_class(ExportXlsLazyAction::class));

        $action = ExportXlsLazyAction::make('export_xls');

        Assert::assertSame('xot-files.xls', $action->getIcon());
        Assert::assertTrue($action->isIconButton());
        Assert::assertSame('', $action->getLabel());
        Assert::assertNotSame('xot::actions.export_xls.icon', $action->getIcon());
        Assert::assertFileExists(module_path('Xot', 'resources/svg/files/xls.svg'));
    });
});
