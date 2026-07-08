<?php

declare(strict_types=1);

namespace Modules\Performance\Actions\Organizzativa;

use Modules\Performance\Models\Individuale;
use Modules\Performance\Models\Organizzativa;
use Spatie\QueueableAction\QueueableAction;

// Log disabilitato per preferenza echo

/**
 * Copia il campo valutatore_id da performance_individuale a performance_organizzativa
 * per tutte le righe con stesso anno, ente, matr, stabi.
 *
 * - Aggiorna solo se trova match esatto.
 * - Documentato secondo le regole Laraxot/WindSurf.
 * - Tipizzazione rigorosa.
 */
class CopyValutatoreIdFromIndividualeAction
{
    use QueueableAction;

    /**
     * Esegue la copia del campo valutatore_id.
     *
     * @return int Numero di record aggiornati
     */
    public function execute(int $anno): int
    {
        $updated = 0;
        // Recupera tutte le organizzative per l'anno
        $organizzative = Organizzativa::where('anno', $anno)->get();

        foreach ($organizzative as $org) {
            $individuale = Individuale::where('anno', $org->anno)
                ->where('ente', $org->ente)
                ->where('matr', $org->matr)
                ->where('stabi', $org->stabi)
                ->first();
            if ($individuale && $individuale->valutatore_id !== null) {
                $org->valutatore_id = $individuale->valutatore_id;
                $org->save();
                $updated++;
            }
        }

        return $updated;
    }
}
