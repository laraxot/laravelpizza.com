<?php

declare(strict_types=1);

namespace Modules\Xot\Actions;

use Illuminate\Support\Facades\Storage;
use Spatie\QueueableAction\QueueableAction;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Html2Pdf;

/**
 * Class HtmlAction.
 */
class HtmlAction
{
    use QueueableAction;

    public static function toPdf(
        string $html,
        string $out = 'show',
        string $pdforientation = 'L',
        string $filename = '',
    ): string {
        if ($filename === '') {
            $filename = Storage::disk('local')->path('test.pdf');
        }

        if (request('debug', false)) {
            return $html;
        }

        try {
            $html2pdf = new Html2Pdf($pdforientation, 'A4', 'it');
            $html2pdf->setTestTdInOnePage(false);
            $html2pdf->WriteHTML($html);
            if ($out === 'content_PDF') {
                return $html2pdf->Output($filename.'.pdf', 'S');
            }

            if ($out === 'file') {
                $html2pdf->Output($filename, 'F');

                return $filename;
            }

            return $html2pdf->Output();
        } catch (Html2PdfException $html2PdfException) {
            $html2pdf->clean();

            // Niente piu' dump ne' return di un path mai scritto: l'handler segnala l'errore.
            throw $html2PdfException;
        }
    }
}
