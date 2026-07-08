<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Actions;

use InvalidArgumentException;
use Modules\IndennitaCondizioniLavoro\Models\CondizioniLavoro;
use Modules\IndennitaCondizioniLavoro\Models\StabiDirigente;
use Spatie\QueueableAction\QueueableAction;
use Spipu\Html2Pdf\Html2Pdf;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MakePdf
{
    use QueueableAction;

    /**
     * @param  array<string, mixed>|null  $data
     */
    public function execute(?array $data): StreamedResponse
    {
        $filtersInput = $data['anno/valutatore'] ?? $data;
        if (! is_array($filtersInput)) {
            throw new InvalidArgumentException('Parametro filtri non valido.');
        }

        $anno = isset($filtersInput['anno']) ? (int) $filtersInput['anno'] : null;
        $valutatoreId = isset($filtersInput['valutatore_id']) ? (int) $filtersInput['valutatore_id'] : null;

        if ($anno === null || $valutatoreId === null) {
            throw new InvalidArgumentException('Filtri anno o valutatore non valorizzati.');
        }

        $filters = [
            'anno' => $anno,
            'valutatore_id' => $valutatoreId,
        ];

        $rows = CondizioniLavoro::query()
            ->where($filters)
            ->whereHas('indennitaTipoDettaglio')
            ->get();

        $valutatore = StabiDirigente::query()
            ->where('valutatore_id', $valutatoreId)
            ->whereRaw('id = valutatore_id')
            ->where('anno', $anno)
            ->first();

        $viewParams = [
            'rows' => $rows,
            'firma' => $valutatore?->nome_diri,
        ];

        $html = view('indennitacondizionilavoro::actions.make-pdf', $viewParams)->render();
        $filename = sprintf('condizioni_lavoro_%d_%d.pdf', $valutatoreId, $anno);

        return response()->streamDownload(
            function () use ($html): void {
                $html2pdf = new Html2Pdf('L', 'A4', 'it');
                $html2pdf->writeHTML($html);
                echo $html2pdf->output('', 'S');
            },
            $filename,
            ['Content-Type' => 'application/pdf'],
        );
    }
}
