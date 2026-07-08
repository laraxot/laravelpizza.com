<?php

declare(strict_types=1);

namespace Modules\Performance\Actions;

use Exception;
use Modules\Performance\Models\Individuale as Scheda;
use Modules\Performance\Models\Valutatore;
use Modules\Xot\Actions\Export\PdfByHtmlAction;
use Spatie\QueueableAction\QueueableAction;

class MakePdfByRecord
{
    use QueueableAction;

    /**
     * Generate PDF for a performance record.
     *
     * @param  Scheda  $record  The performance record
     * @param  string  $out  Output type ('download' or other)
     * @return mixed The PDF output
     *
     * @throws Exception If valutatore relation is not loaded
     */
    public function execute(Scheda $record, string $out = 'download'): mixed
    {
        $view = 'performance::actions.make-pdf-by-record';

        $valutatore = $record->valutatore;
        if (! $valutatore instanceof Valutatore) {
            throw new Exception('Valutatore relation not loaded or invalid');
        }
        $view_params = [
            'view' => $view,
            'row' => $record,
            'title' => 'Progressione anno '.$record->anno,
            'firma' => $valutatore->nome_diri,
        ];

        $view_out = view($view, $view_params);

        $html = $view_out->render();
        $filename = 'scheda_'.$record->id.'_'.$record->matr.'_'.$record->cognome.'_'.$record->nome.'.pdf';

        return app(PdfByHtmlAction::class)->execute(
            html: $html,
            filename: $filename,
            disk: 'cache',
            out: $out,
        );
    }
}
