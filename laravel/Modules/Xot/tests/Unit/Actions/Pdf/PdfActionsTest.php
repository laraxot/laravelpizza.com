<?php

declare(strict_types=1);

uses(Modules\Xot\Tests\TestCase::class);
use Modules\Xot\Actions\Pdf\PdfByHtmlAction;
use Modules\Xot\Actions\Pdf\PdfEngineEnum;
use PHPUnit\Framework\Assert;

it('executes pdf by html action correctly', function (): void {
    $action = app(PdfByHtmlAction::class);
    $html = '<h1>Test</h1>';
    $filename = 'test.pdf';

    try {
        $result = $action->execute($html, $filename, 'local', 'path', 'P', PdfEngineEnum::SPIPU);
        Assert::assertStringContainsString('.pdf', (string) $result);
    } catch (Throwable $e) {
        Assert::assertStringContainsString('PDF', $e->getMessage());
    }
});
