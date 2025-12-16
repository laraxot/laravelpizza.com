<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Pdf;

use Exception;
use Spatie\QueueableAction\QueueableAction;
use Spipu\Html2Pdf\Html2Pdf;
use Webmozart\Assert\Assert;

/**
 * Action to generate PDF content as binary data for email attachments.
 *
 * This action is similar to StreamDownloadPdfAction but returns raw PDF content
 * instead of a download response, making it suitable for email attachments.
 */
class ContentPdfAction
{
    use QueueableAction;

    public PdfEngineEnum $engine;

    /**
     * Genera contenuto PDF dall'HTML fornito.
     *
     * @param  string|null  $html  Contenuto HTML da convertire
     * @param  string|null  $view  Nome della vista Blade da renderizzare
     * @param  array<string, mixed>|null  $data  Dati da passare alla vista
     * @param  string  $_filename  Nome del file PDF (per riferimento, attualmente non utilizzato)
     * @return string Contenuto binario del PDF
     *
     * @throws Exception Se la vista non esiste
     */
    public function execute(
        ?string $html = null,
        ?string $view = null,
        ?array $data = null,
        string $_filename = 'my_doc.pdf',
    ): string {
        // Generate HTML content if view is provided
        if ($html === null && $view !== null) {
            if (! view()->exists($view)) {
                throw new Exception('View '.$view.' not found');
            }
            if (! is_array($data)) {
                $data = [];
            }
            $html = view($view, $data)->render();
        }

        // Validate that we have HTML content
        Assert::string($html, 'HTML content must be provided either directly or via view rendering');

        // Create HTML2PDF instance with same configuration as StreamDownloadPdfAction
        $html2pdf = new Html2Pdf(
            orientation: 'P', // Portrait
            format: 'A4', // A4 format
            lang: 'it', // Italian language
            unicode: true, // Unicode support
            encoding: 'UTF-8', // UTF-8 encoding
            margins: [10, 10, 10, 10], // 10mm margins on all sides
        );

        // Write HTML content to PDF
        $html2pdf->writeHTML($html);

        // Generate and return PDF content as binary string
        return $html2pdf->output('', 'S'); // 'S' returns string content
    }

    /**
     * Genera contenuto PDF da una vista con dati specifici.
     *
     * Metodo di convenienza per generare PDF da viste Blade.
     *
     * @param  string  $view  Nome della vista Blade
     * @param  array  $data  Dati da passare alla vista
     * @param  string  $filename  Nome del file PDF (per riferimento)
     * @return string Contenuto binario del PDF
     */
    /**
     * @param  array<string, mixed>  $data
     */
    public function fromView(string $view, array $data = [], string $filename = 'document.pdf'): string
    {
        return $this->execute(
            html: null,
            view: $view,
            data: $data,
            _filename: $filename,
        );
    }

    /**
     * Genera contenuto PDF da HTML diretto.
     *
     * Metodo di convenienza per generare PDF da contenuto HTML.
     *
     * @param  string  $html  Contenuto HTML
     * @param  string  $filename  Nome del file PDF (per riferimento)
     * @return string Contenuto binario del PDF
     */
    public function fromHtml(string $html, string $filename = 'document.pdf'): string
    {
        return $this->execute(
            html: $html,
            view: null,
            data: null,
            _filename: $filename,
        );
    }
}
