<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Pdf\Engine;

use Illuminate\Support\Facades\Storage;
use Spatie\QueueableAction\QueueableAction;
use Spipu\Html2Pdf\Html2Pdf;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class SpipuPdfByHtmlAction
{
    use QueueableAction;

    public function execute(
        string $html,
        string $filename = 'my_doc.pdf',
        string $disk = 'cache',
        string $out = 'download',
        string $orientation = 'P',
    ): string|BinaryFileResponse {
        $html2pdf = new Html2Pdf($orientation, 'A4', 'it');
        $html2pdf->setTestTdInOnePage(false);
        $html2pdf->writeHTML($html);
        $path = Storage::disk($disk)->path($filename);
        $html2pdf->output($path, 'F');

        $headers = [
            'Content-Type' => 'application/pdf',
        ];

        return match ($out) {
            'download' => response()->download($path, $filename, $headers),
            'content' => $html2pdf->output($path, 'S'), // D
            default => $path,
        };
    }
}
