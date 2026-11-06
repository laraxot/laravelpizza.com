<?php

declare(strict_types=1);
use Illuminate\Support\Facades\Facade;
use Modules\Xot\Actions\Pdf\MakePdfSpatieTestAction;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\StreamedResponse;

uses(TestCase::class);

it('builds a streamed pdf download response for the generic test view', function (): void {
    Facade::setFacadeApplication(app());

    $response = app(MakePdfSpatieTestAction::class)->execute([
        'document_id' => 'demo-001',
        'report_name' => 'Generic PDF Test',
        'generated_for' => 'unit-test',
    ]);

    Assert::assertInstanceOf(StreamedResponse::class, $response);
    Assert::assertSame('application/pdf', $response->headers->get('Content-Type'));
    Assert::assertStringContainsString('spatie-pdf-test.pdf', (string) $response->headers->get('content-disposition'));
});
