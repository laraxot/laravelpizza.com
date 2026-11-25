<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Filament\Actions\Table;

use Modules\Xot\Filament\Actions\Table\PdfAction;
use Modules\Xot\Filament\Actions\XotBaseAction;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('PdfAction — table row PDF UX', function (): void {
    test('icona xot-files.pdf, solo icona, tooltip da export_pdf', function (): void {
        Assert::assertSame(XotBaseAction::class, get_parent_class(PdfAction::class));

        $action = PdfAction::make('pdf');

        Assert::assertSame('xot-files.pdf', $action->getIcon());
        Assert::assertTrue($action->isIconButton());
        Assert::assertSame('', $action->getLabel());
        Assert::assertFileExists(module_path('Xot', 'resources/svg/files/pdf.svg'));
    });
});
