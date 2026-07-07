<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Pdf;

<<<<<<< HEAD
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Enums\Format;
use Spatie\LaravelPdf\Facades\Pdf;
=======
use Modules\Xot\Contracts\PdfBuilderContract;
use Modules\Xot\Support\PdfBuilderAdapter;

use function Safe\base64_decode;

>>>>>>> 40b96bcd6 (.)
use Spatie\QueueableAction\QueueableAction;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MakePdfSpatieTestAction
{
    use QueueableAction;

    /**
     * Build a minimal Spatie PDF download response from a generic test view.
     *
     * @param array<string, mixed> $data
     */
    public function execute(
        array $data = [],
        string $filename = 'spatie-pdf-test.pdf',
        string $view = 'xot::pdf.spatie-test',
    ): StreamedResponse {
<<<<<<< HEAD
        /** @var \Spatie\LaravelPdf\PdfBuilder $pdfBuilder */
        $pdfBuilder = Pdf::view($view, [
            'title' => 'Spatie PDF Test',
            'generated_at' => now(),
            'payload' => $data,
        ]);

        $pdfBuilder->format(Format::A4);
        $pdfBuilder->name($filename);
        $pdfBuilder->withBrowsershot(function (Browsershot $browsershot): void {
            $browsershot->showBackground();

            $nodeBinary = config('laravel-pdf.browsershot.node_binary');
            if (is_string($nodeBinary) && '' !== $nodeBinary) {
                $browsershot->setNodeBinary($nodeBinary);
            }

            $npmBinary = config('laravel-pdf.browsershot.npm_binary');
            if (is_string($npmBinary) && '' !== $npmBinary) {
                $browsershot->setNpmBinary($npmBinary);
            }

            $chromePath = config('laravel-pdf.browsershot.chrome_path');
            if (is_string($chromePath) && '' !== $chromePath) {
                $browsershot->setChromePath($chromePath);
            }
        });

        $pdfBuilder->download();

        return new StreamedResponse(
            static function () use ($pdfBuilder): void {
                /** @var string $base64 */
                $base64 = $pdfBuilder->base64();
                echo \Safe\base64_decode($base64);
=======
        $pdf = $this->makePdfBuilder($view, $data, $filename);

        return new StreamedResponse(
            static function () use ($pdf): void {
                echo base64_decode($pdf->base64());
>>>>>>> 40b96bcd6 (.)
            },
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="'.$filename.'"',
            ],
        );
    }
<<<<<<< HEAD
=======

    /**
     * @param array<string, mixed> $data
     */
    private function makePdfBuilder(string $view, array $data, string $filename): PdfBuilderContract
    {
        $pdfFacadeClass = 'Spatie\\LaravelPdf\\Facades\\Pdf';
        if (! class_exists($pdfFacadeClass)) {
            throw new \RuntimeException('spatie/laravel-pdf facade is not available.');
        }

        $builder = $pdfFacadeClass::view($view, [
            'title' => 'Spatie PDF Test',
            'generated_at' => now(),
            'payload' => $data,
        ]);

        if (! is_object($builder)) {
            throw new \RuntimeException('Spatie PDF builder was not created correctly.');
        }

        return (new PdfBuilderAdapter($builder))
            ->format('a4')
            ->name($filename)
            ->download()
            ->withBrowsershot(function (object $browsershot): void {
                if (! method_exists($browsershot, 'showBackground')) {
                    throw new \RuntimeException('Browsershot instance does not expose showBackground().');
                }

                $browsershot->showBackground();

                $nodeBinary = config('laravel-pdf.browsershot.node_binary');
                if (is_string($nodeBinary) && '' !== $nodeBinary && method_exists($browsershot, 'setNodeBinary')) {
                    $browsershot->setNodeBinary($nodeBinary);
                }

                $npmBinary = config('laravel-pdf.browsershot.npm_binary');
                if (is_string($npmBinary) && '' !== $npmBinary && method_exists($browsershot, 'setNpmBinary')) {
                    $browsershot->setNpmBinary($npmBinary);
                }

                $chromePath = config('laravel-pdf.browsershot.chrome_path');
                if (is_string($chromePath) && '' !== $chromePath && method_exists($browsershot, 'setChromePath')) {
                    $browsershot->setChromePath($chromePath);
                }
            });
    }
>>>>>>> 40b96bcd6 (.)
}
