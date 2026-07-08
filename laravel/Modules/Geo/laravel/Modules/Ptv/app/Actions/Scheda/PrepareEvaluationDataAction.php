<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\Scheda;

use Illuminate\Database\Eloquent\Model;
use Modules\Ptv\Models\Contracts\SchedaContract;
use Modules\Ptv\Models\Valutatore;
use Spatie\QueueableAction\QueueableAction;

/**
 * Action per preparare i dati di valutazione da un record scheda.
 *
 * Questa action estrae tutti i dati di valutazione necessari per logging,
 * report e audit trail, inclusi dati del valutatore se caricato.
 */
class PrepareEvaluationDataAction
{
    use QueueableAction;

    /**
     * Prepara i dati di valutazione strutturati per Activity Log.
     *
     * @param  SchedaContract  $record  Il record della scheda
     * @return array<string, mixed> Dati di valutazione strutturati
     */
    public function execute(SchedaContract $record): array
    {
        $evaluationData = [
            'matr' => $record->matr ?? null,
            'cognome' => $record->cognome ?? null,
            'nome' => $record->nome ?? null,
            'anno' => $record->anno ?? null,
            'ente' => $record->ente ?? null,
            'stabi' => $record->stabi ?? null,
            'repar' => $record->repar ?? null,
            'valutatore_id' => null,
            'valutatore_nome' => null,
        ];

        // Estrae dati valutatore se la relazione esiste ed è caricata
        if ($record instanceof Model) {
            if (
                method_exists($record, 'valutatore') &&
                $record->relationLoaded('valutatore')
            ) {
                // Usa getAttribute per accedere alla relazione in modo sicuro
                $valutatore = $record->getAttribute('valutatore');
                if ($valutatore !== null && is_object($valutatore)) {
                    /** @var Valutatore $valutatore */
                    $evaluationData['valutatore_id'] = $valutatore->id ?? null;
                    $evaluationData['valutatore_nome'] = $valutatore->nome_diri ?? null;
                }
            }
        }

        return $evaluationData;
    }
}
