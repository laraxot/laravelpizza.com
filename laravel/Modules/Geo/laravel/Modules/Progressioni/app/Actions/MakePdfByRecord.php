<?php

declare(strict_types=1);

namespace Modules\Progressioni\Actions;

use Modules\Progressioni\Models\Progressioni;
use Modules\Progressioni\Models\Scheda;
use Modules\Xot\Actions\Export\PdfByHtmlAction;
use Spatie\QueueableAction\QueueableAction;

class MakePdfByRecord
{
    use QueueableAction;

    /**
     * Undocumented function.
     */
    public function execute(Scheda|Progressioni $record, string $out = 'download'): mixed
    {
        $view = 'progressioni::actions.make-pdf-by-record';

        $valutatore = $record->valutatore;
        $view_params = [
            'view' => $view,
            'row' => $record,
            'title' => 'Progressione anno '.$record->anno,
            'firma' => $valutatore->nome_diri ?? '',
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
