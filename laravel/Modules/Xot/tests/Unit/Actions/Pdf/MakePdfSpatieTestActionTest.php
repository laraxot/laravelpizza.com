<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\Pdf;

use Illuminate\Support\Facades\Facade;
use Modules\Xot\Actions\Pdf\MakePdfSpatieTestAction;
use Symfony\Component\HttpFoundation\StreamedResponse;

it('builds a streamed pdf download response for the generic test view', function (): void {
    Facade::setFacadeApplication(app());

    $response = app(MakePdfSpatieTestAction::class)->execute([
        'document_id' => 'demo-001',
        'report_name' => 'Generic PDF Test',
        'generated_for' => 'unit-test',
    ]);

    expect($response)->toBeInstanceOf(StreamedResponse::class)
        ->and($response->headers->get('Content-Type'))->toBe('application/pdf')
        ->and($response->headers->get('content-disposition'))->toContain('attachment;')
        ->and($response->headers->get('content-disposition'))->toContain('spatie-pdf-test.pdf');
});
