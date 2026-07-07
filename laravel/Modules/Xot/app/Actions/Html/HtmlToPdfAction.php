<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Html;

use Illuminate\Support\Facades\Storage;
use Spatie\QueueableAction\QueueableAction;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Html2Pdf;

/**
 * Replaces Modules\Xot\Services\HtmlService::toPdf() (archived to .bak).
 *
 * ponytail: kept as a 1:1 port of the original Spipu Html2Pdf call rather than
 * routing through Modules\Xot\Actions\Pdf\PdfByHtmlAction, because that Action
 * currently has its own unrelated PdfEngineEnum duplication issue
 * (Actions/Pdf/PdfEngineEnum.php vs Enums/PdfEngineEnum.php) that needs its
 * own dedicated fix before other code can safely depend on it.
 */
class HtmlToPdfAction
{
    use QueueableAction;

    public function execute(
        string $html,
        string $out = 'show',
        string $pdforientation = 'L',
        string $filename = '',
    ): string {
        if ('' === $filename) {
            $filename = Storage::disk('local')->path('test.pdf');
        }

        if (request('debug', false)) {
            return $html;
        }

        try {
            $html2pdf = new Html2Pdf($pdforientation, 'A4', 'it');
            $html2pdf->setTestTdInOnePage(false);
            $html2pdf->WriteHTML($html);
            if ('content_PDF' === $out) {
                return $html2pdf->Output($filename.'.pdf', 'S');
            }

            if ('file' === $out) {
                $html2pdf->Output($filename, 'F');

                return $filename;
            }

            return $html2pdf->Output();
        } catch (Html2PdfException $html2PdfException) {
            $html2pdf->clean();

            $formatter = new ExceptionFormatter($html2PdfException);
            dddx($formatter->getHtmlMessage());
            echo $formatter->getHtmlMessage();
        }

        return $filename;
    }
}
