<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\Scheda;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\QueueableAction\QueueableAction;

/**
 * Aggiorna l'importo totale basandosi sui resti ponderati per valutatore_id.
 */
class UpdateImportoTotaleByValutatoreIdAction
{
    use QueueableAction;

    /**
     * @param  class-string<Model>  $class
     */
    public function execute(string $class, string $year, string $type): void
    {
        echo "<br/>Aggiornamento importo totale per valutatore_id, anno: {$year}, tipo: {$type}\n";

        // Prima azzera l'importo totale per tutte le schede dell'anno
        $class::where('anno', $year)
            ->where('type', $type)
            ->update(['importo_totale' => 0]);

        // Poi aggiorna l'importo totale per le schede con diritto
        $updated = $class::where('anno', $year)
            ->where('type', $type)
            ->where('ha_diritto', '>', 0)
            ->update([
                'importo_totale' => DB::raw('quota_effettiva + resti_pond'),
            ]);

        echo "Importo totale per valutatore_id aggiornato per {$updated} record, anno: {$year}, tipo: {$type}\n";

        // Verifica la somma totale per assicurare la correttezza
        $sumImportoTotale = $class::where('anno', $year)
            ->where('type', $type)
            ->sum('importo_totale');

        $sumBudgetAssegnato = $class::where('anno', $year)
            ->where('type', $type)
            ->sum('budget_assegnato');

        $delta = abs($sumImportoTotale - $sumBudgetAssegnato);

        if ($delta > 0.1) {
            echo 'Potenziale discrepanza nella redistribuzione per valutatore_id: '.
                "importo_totale = {$sumImportoTotale}, budget_assegnato = {$sumBudgetAssegnato}, ".
                "delta = {$delta}, anno: {$year}, tipo: {$type}\n";
        } else {
            echo "Verifica passata: somma importo_totale = {$sumImportoTotale}, ".
                "budget_assegnato = {$sumBudgetAssegnato}, ".
                "anno: {$year}, tipo: {$type}\n";
        }
    }
}
