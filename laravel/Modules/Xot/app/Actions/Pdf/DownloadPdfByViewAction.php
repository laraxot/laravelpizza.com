<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Pdf;

use Illuminate\Support\Str;
use Spatie\QueueableAction\QueueableAction;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Genera un PDF da una view Blade e restituisce la risposta di download.
 *
 * Usa spipu/html2pdf per la generazione. Pensato per export da ListRecords
 * (es. ExportPdfAction) dove la view riceve `rows` e altri parametri.
 */
class DownloadPdfByViewAction
{
    use QueueableAction;

    /**
     * Genera PDF dalla view e restituisce StreamedResponse per il download.
     *
     * @param  string  $view  Nome view (es. indennita-responsabilita::indennita_responsabilita.index.pdf)
     * @param  array<string, mixed>  $viewParams  Dati per la view (es. ['rows' => $rows])
     * @param  string|null  $filename  Nome file per il download (opzionale)
     */
    public function execute(
        string $view,
        array $viewParams = [],
        ?string $filename = null,
    ): StreamedResponse {
        $filename ??= $this->deriveFilenameFromView($view);

        return app(StreamDownloadPdfAction::class)->execute(
            html: null,
            view: $view,
            data: $viewParams,
            filename: $filename,
        );
    }

    /**
     * Deriva un nome file sensato dal nome della view.
     */
    protected function deriveFilenameFromView(string $view): string
    {
        $base = Str::after($view, '::');
        $base = Str::beforeLast($base, '.pdf');
        $base = Str::replace('.', '-', $base);

        return Str::slug($base).'.pdf';
    }
}
