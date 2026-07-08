<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Actions;

use Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita;
use Modules\IndennitaResponsabilita\Models\StabiDirigente;
use Modules\Xot\Actions\Export\PdfByHtmlAction;
use Spatie\QueueableAction\QueueableAction;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class MakePdfByRecord
{
    use QueueableAction;

    /**
     * Execute PDF generation for a specific Indennita Responsabilita record.
     */
    public function execute(IndennitaResponsabilita $record, string $out = 'download'): string|BinaryFileResponse
    {
        $view = 'indennitaresponsabilita::actions.make-pdf-by-record';
        /*
        $values = $data['anno/valutatore'];
        $rows = IndennitaResponsabilita::with(['ratings'])
            ->where($values)
            ->whereHas('ratings')
            ->get();

        $valutatore=StabiDirigente::where('valutatore_id',$values['valutatore_id'])
            ->whereRaw('id=valutatore_id')
            ->where('anno',$values['anno'])
            ->first();
        */
        $valutatore = $record->valutatore;
        $view_params = [
            'view' => $view,
            'row' => $record,
            'title' => 'Indennita Responsabilita anno '.$record->anno,
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
